<?php

namespace app\controllers;

use yii;
use app\models\Magnitud;
use app\models\Gerencia;
use app\models\Cargo;
use app\models\PersonaNatural;
use app\models\Personal;
use app\models\Registro;
use app\models\Estados;
use app\models\NaturalezaAccidente;
use app\models\RegistroSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Response;

/**
 * RegistroController implements the CRUD actions for Registro model.
 */
class RegistroController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
                'access' => [
                    'class' => AccessControl::class,
                    'only' => [
                        'index', 'create', 'update', 'delete', 'permisos',
                    ], 
                    'rules' => [
                        ['actions' => ['index'], 'allow' => true, 'roles' => ['registro/index']],
                        ['actions' => ['create'], 'allow' => true, 'roles' => ['registro/create']],
                        ['actions' => ['update'], 'allow' => true, 'roles' => ['registro/update']],
                        ['actions' => ['delete'], 'allow' => true, 'roles' => ['registro/delete']],
                        ['actions' => ['permisos'], 'allow' => true, 'roles' => ['registro/permisos']],
                    ]
                ]
            ]
        );
    }

    /**
     * Lists all Registro models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new RegistroSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Registro model.
     * @param int $id_registro Id Registro
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_registro)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_registro),
        ]);
    }

    /**
     * Creates a new Registro model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Registro();
        $modelPersonaNatural = new PersonaNatural();
        $personalData = null; // Variable para almacenar los datos de Personal

        if ($this->request->isPost) {
            Yii::info("Datos POST recibidos: " . print_r($this->request->post(), true)); // Verifica los datos enviados

            if ($model->load($this->request->post())) {
                Yii::debug("Modelo cargado: " . print_r($model->attributes, true)); // Verifica los datos del modelo
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    // **1. Obtener el código de la región desde la tabla Estados**
                    $estado = Estados::findOne($model->id_estado); // Supongo que `id_estado` está relacionado
                    $codigoRegion = $estado !== null ? $estado->codigo_region : '00'; // Fallback a '00' si no hay región

                    // **2. Obtener los dos últimos dígitos del año actual**
                    $year = date('y');

                    // **3. Consultar el último registro del mismo año y región**
                    $ultimoAccidente = Registro::find()
                        ->where(['like', 'nro_accidente', $codigoRegion . '0' . $year . '%', false]) // Filtrar por código región y año
                        ->orderBy(['nro_accidente' => SORT_DESC])
                        ->one();

                    // **4. Generar el correlativo**
                    if ($ultimoAccidente) {
                        // Extraer el correlativo del último registro (asumo que siempre tiene 5 dígitos)
                        $ultimoCorrelativo = (int)substr($ultimoAccidente->nro_accidente, 5, 5); // 5 caracteres desde la posición 5
                        $correlativo = str_pad($ultimoCorrelativo + 1, 5, '0', STR_PAD_LEFT); // Incrementar y formatear a 5 dígitos
                    } else {
                        $correlativo = '00001'; // Si no hay registros previos, iniciar en '00001'
                    }

                    // **5. Obtener la descripción de la naturaleza desde la tabla NaturalezaAccidente**
                    $naturalezaAccidente = NaturalezaAccidente::findOne($model->id_naturaleza_accidente);
                    $descripcionNaturaleza = $naturalezaAccidente !== null ? $naturalezaAccidente->codigo : '';

                    // **6. Generar el número de accidente final**
                    $model->nro_accidente = $codigoRegion . '0' . $year . $correlativo . $descripcionNaturaleza;

                    // **7. Asignar cedula_pers_accide en todos los casos**
                   // $model->cedula_pers_accide = $this->request->post('Registro')['cedula_pers_accide'];

                    // **8. Guardar el registro principal**
                    Yii::info("Intentando guardar el registro principal...");
                    if (!$model->save(false)) {
                        throw new \yii\db\Exception('Error al guardar el registro principal: ' . json_encode($model->errors));
                    }
                    Yii::info("Registro principal guardado con éxito.");

                    // **9. Obtener el ID del registro principal**
                    $idRegistroPrincipal = $model->id_registro;

                    // **10. Validar y guardar según la naturaleza del accidente**
                    switch ($model->id_naturaleza_accidente) {
                        case 2: // LABORAL
                        case 19: // NO LABORAL
                        case 79: // TRANSITO
                            // Verificar si la cédula existe en Personal
                            $personal = Personal::findOne(['ci' => $model->cedula_pers_accide]);
                            if (!$personal) {
                                throw new \yii\db\Exception('La cédula no existe en la tabla Personal.');
                            }
                            // Asignar la cédula al campo cedula_pers_accide
                            $model->cedula_pers_accide = $personal->ci;

                            break;

                        case 31: // TERCERO RELACIONADO
                        case 35: // TERCERO NO RELACIONADO
                            // Guardar PersonaNatural
                            $modelPersonaNatural->load($this->request->post());
                            $model->cedula_pers_accide = $modelPersonaNatural->cedula;
                            $modelPersonaNatural->id_registro = $idRegistroPrincipal; // Asignar id_registro
                            if (!$modelPersonaNatural->save(false)) {
                                throw new \yii\db\Exception('Error al guardar Persona Natural: ' . json_encode($modelPersonaNatural->errors));
                            }
                            break; 

                        case 61: // OPERACIONAL
                        case 92: // AMBIENTAL
                            $model->cedula_pers_accide = null; // No hay persona asociada
                            break;   

                    }

                    // **11. Guardar el registro principal**
                    if (!$model->save(false)) {
                        throw new \yii\db\Exception('Error al guardar el registro: ' . json_encode($model->errors));
                    }

                    $transaction->commit();

                    Yii::$app->session->setFlash('success', 'Registro guardado exitosamente. Número de accidente: ' . $model->nro_accidente);
                    return $this->redirect(['index', 'id_registro' => $model->id_registro]);
                } catch (\Exception $e) {
                    
                    yii::error("No guardo".$e);
                    $transaction->rollBack();
                    Yii::$app->session->setFlash('error', 'Error al guardar el registro: ' . $e->getMessage());

                }
            }
        }

        // Obtener las magnitudes para el dropdown
        $magnitudes = ArrayHelper::map(Magnitud::find()->all(), 'id_magnitud', 'descripcion');

        return $this->render('create', [
            'model' => $model,
            'modelPersonaNatural' => $modelPersonaNatural,
            'personalData' => $personalData, // Pasa los datos de Personal a la vista
            'magnitudes' => $magnitudes, // Pasar el array de magnitudes a la vista
        ]);
    }

    public function actionGetEstados()
    {
        $regionId = Yii::$app->request->get('regionId');

        if ($regionId) {
            $estados = Estados::find()
                ->where(['id_regiones' => $regionId])
                ->all();

            $estadosData = ArrayHelper::map($estados, 'id_estado', 'descripcion');

            return \yii\helpers\Json::encode($estadosData);
        } else {
            return '';
        }
    }

    public function actionBuscarPersonal($cedula)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $personal = Personal::findOne(['ci' => $cedula]);

        if ($personal) {
            $cargo = Cargo::findOne($personal->id_cargo); // Obtener el registro de Cargo
            $descripcionCargo = $cargo ? $cargo->descripcion : 'Cargo no encontrado'; // Obtener la descripción o un mensaje de error

            return [
                'success' => true,
                'nombre' => $personal->nombre,
                'apellido' => $personal->apellido,
                'cargo' => $descripcionCargo, // Usar la descripción del cargo
                'nro_empleado' => $personal->nro_empleado,
                'telefono' => $personal->telefono,
            ];
        } else {
            return ['success' => false];
        }
    }

    /**
     * Updates an existing Registro model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_registro Id Registro
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_registro)
    {
        $model = $this->findModel($id_registro);
        $modelPersonaNatural= new PersonaNatural();

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Actualizacion exitosa.');
            return $this->redirect(['index', 'id_registro' => $model->id_registro]);
        }

        return $this->render('update', [
            'model' => $model,
            'modelPersonaNatural' => $modelPersonaNatural,
        ]);
    }

    /**
     * Deletes an existing Registro model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_registro Id Registro
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_registro)
    {
        $this->findModel($id_registro)->delete();
        Yii::$app->session->setFlash('success', 'Se ha eliminado exitosamente.');
        return $this->redirect(['index']);
    }

    

    //Funcion paravalidar la cedula en el campo de busqueda del formulario.
    public function actionValidarCedula()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            $cedula = Yii::$app->request->post('search');

            // Validación básica de la cédula (puedes agregar más validaciones)
            if (!is_numeric($cedula)) {
                return ['error' => 'La cédula debe ser un número'];
            }

            $modelPersonal = new Personal();
            $datosPersona = $modelPersonal->buscarPersonaRegistro($cedula);

            if ($datosPersona) {
                return $datosPersona;
            } else {
                return ['error' => 'Datos no encontrados. Por favor, registre al personal.'];
            }
        }
    }
    
    /**
     * Finds the Registro model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_registro Id Registro
     * @return Registro the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_registro)
    {
        if (($model = Registro::findOne(['id_registro' => $id_registro])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}