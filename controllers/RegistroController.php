<?php

namespace app\controllers;

use yii;
use app\models\Magnitud;
use app\models\RegistroAdicional;
use app\models\Cargo;
use app\models\PersonaNatural;
use app\models\Personal;
use app\models\Registro;
use app\models\Estados;
use app\models\RegistroSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

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
        $modelPersonaNatural = [new PersonaNatural()];
        $modelSupervisor = new PersonaNatural();
        $personalData = null;
        $model->scenario = Registro::SCENARIO_PRIMERA;


        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $transaction = Yii::$app->db->beginTransaction();
                try {

                    // 1. Establecer el estatus de proceso inicial
                    $model->id_estatus_proceso = 6; // Ajusta según tu lógica de negocio

                    // 2. Generar número de accidente
                    $model->GenerarNumeroAccidente();

                    // Manejar el supervisor manual (no como array)
                    $naturalezaId = $model->id_naturaleza_accidente;
                    
                    if ($naturalezaId == 31 || $naturalezaId == 35) {
                        // Cargar datos del supervisor manual directamente
                        if ($modelSupervisor->load($this->request->post())) {
                            $modelSupervisor->id_registro = $model->id_registro;
                            
                            if (!$modelSupervisor->save()) {
                                throw new \yii\db\Exception('Error al guardar supervisor: ' . json_encode($modelSupervisor->errors));
                            }
                            
                            // Asignar cédula del supervisor al modelo principal
                            $model->cedula_supervisor_60min = $modelSupervisor->cedula;
                        }
                    } else {
                        // Para otros casos, usar la cédula del campo oculto
                        $model->cedula_supervisor_60min = $this->request->post('Registro')['cedula_supervisor_60min'] ?? null;
                    }

                    // 3. Obtener datos de personas
                    $personasData = $this->request->post('PersonaNatural', []);
                    $cedulasPersonas = [];
                    
                    if ($model->id_naturaleza_accidente == 31 || $model->id_naturaleza_accidente == 35) {
                        // Para Personas Naturales
                        foreach ($personasData as $index => $data) {
                            if (!empty($data['cedula'])) {
                                $cedulasPersonas[$index] = $data['cedula'];
                            }
                        }
                    } else {
                        // Para otros tipos
                        $cedulasPersonas = array_filter($this->request->post('Registro')['cedula_pers_accide'] ?? [], function($cedula) {
                            return !empty($cedula) && is_numeric($cedula) && strlen($cedula) >= 8;
                        });
                    }

                    // 4. Guardar registro principal
                    if (!empty($cedulasPersonas)) {
                        $model->cedula_pers_accide = reset($cedulasPersonas);
                    }

                    if (!$model->save(false)) {
                        throw new \yii\db\Exception('Error al guardar registro principal: ' . json_encode($model->errors));
                    }

                    $idRegistroPrincipal = $model->id_registro;

                    // 5. Guardar naturaleza adicional
                    if (isset($_POST['naturaleza_adicional'])) {
                        $registroAdicional = new RegistroAdicional();
                        $registroAdicional->id_registro = $idRegistroPrincipal;
                        $registroAdicional->nro_accidente = $model->nro_accidente;
                        $registroAdicional->id_naturaleza_accidente = $_POST['naturaleza_adicional'];
                        $registroAdicional->id_estatus_proceso = $model->id_estatus_proceso; // Mismo estatus
                        $registroAdicional->id_magnitud = $model->id_magnitud;
                        $registroAdicional->acciones_tomadas_60min = $model->acciones_tomadas_60min;
                        
                        if (!$registroAdicional->save()) {
                            throw new \yii\db\Exception('Error al guardar naturaleza adicional: ' . json_encode($registroAdicional->errors));
                        }
                    }

                    // 6. Manejar registros secundarios
                    if ($model->id_naturaleza_accidente == 31 || $model->id_naturaleza_accidente == 35) {
                        // Personas Naturales - incluyendo la primera (índice 0)
                        foreach ($personasData as $index => $data) {
                            if (!empty($data['cedula'])) {
                                if ($index == 0) {
                                    // Para la primera persona, asociarla al registro principal
                                    $personaNatural = new PersonaNatural();
                                    $personaNatural->attributes = $data;
                                    $personaNatural->id_registro = $model->id_registro;
                                    
                                    if (!$personaNatural->save()) {
                                        throw new \yii\db\Exception('Error al guardar Persona Natural: ' . json_encode($personaNatural->errors));
                                    }
                                    
                                    // Actualizar el registro principal con la cédula
                                    $model->cedula_pers_accide = $data['cedula'];
                                    if (!$model->save(false)) {
                                        throw new \yii\db\Exception('Error al actualizar registro principal: ' . json_encode($model->errors));
                                    }
                                } else {
                                    // Para personas adicionales, crear nuevos registros
                                    $registroPersona = new Registro();
                                    $registroPersona->attributes = $model->attributes;
                                    $registroPersona->cedula_pers_accide = $data['cedula'];
                                    $registroPersona->id_estatus_proceso = $model->id_estatus_proceso;
                                    
                                    if (!$registroPersona->save(false)) {
                                        throw new \yii\db\Exception('Error al guardar registro secundario: ' . json_encode($registroPersona->errors));
                                    }
                                    
                                    $personaNatural = new PersonaNatural();
                                    $personaNatural->attributes = $data;
                                    $personaNatural->id_registro = $registroPersona->id_registro;
                                    
                                    if (!$personaNatural->save()) {
                                        throw new \yii\db\Exception('Error al guardar Persona Natural adicional: ' . json_encode($personaNatural->errors));
                                    }
                                }
                            }
                        }
                    } else {
                        // Personal normal
                        if (count($cedulasPersonas) > 1) {
                            $restoCedulas = array_slice($cedulasPersonas, 1);
                            
                            foreach ($restoCedulas as $cedula) {
                                $registroPersona = new Registro();
                                $registroPersona->attributes = $model->attributes;
                                $registroPersona->cedula_pers_accide = $cedula;
                                $registroPersona->id_estatus_proceso = $model->id_estatus_proceso; // Establecer estatus
                                
                                if (!$registroPersona->save(false)) {
                                    throw new \yii\db\Exception('Error al guardar registro secundario: ' . json_encode($registroPersona->errors));
                                }
                            }
                        }
                    }

                    $transaction->commit();
                    Yii::$app->session->setFlash('success', 'Registro guardado. N° Accidente: ' . $model->nro_accidente);
                    return $this->redirect(['index', 'id_registro' => $model->id_registro]);
                } catch (\Exception $e) {
                    $transaction->rollBack();
                    Yii::$app->session->setFlash('error', 'Error: ' . $e->getMessage());
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
            'modelPersonaNatural' => $modelPersonaNatural,
            'modelSupervisor' => $modelSupervisor,
            'personalData' => $personalData,
            'magnitudes' => ArrayHelper::map(Magnitud::find()->all(), 'id_magnitud', 'descripcion'),
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
        $personasNaturales = PersonaNatural::find()->all();
        $model->scenario = Registro::SCENARIO_UPDATE;
        
        // Asegurar que al menos hay un modelo disponible
        $modelPersonaNatural = $personasNaturales ?: [new PersonaNatural()];
        $modelSupervisor = new PersonaNatural();
        $personalData = null;

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Actualización exitosa.');
            return $this->redirect(['index', 'id_registro' => $model->id_registro]);
        }

        return $this->render('update', [
            'model' => $model,
            'modelPersonaNatural' => $modelPersonaNatural,
            'modelSupervisor' => $modelSupervisor,
            'personalData' => $personalData,
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