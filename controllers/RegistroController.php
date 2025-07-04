<?php

namespace app\controllers;

use yii;
use yii\web\View;
use app\models\Magnitud;
use app\models\RegistroAdicional;
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
        
        // Obtener todos los registros únicos por nro_accidente
        $uniqueAccidents = Registro::find()
            ->select(['MIN(registro.id_registro) as id_registro', 'nro_accidente'])
            ->groupBy('nro_accidente')
            ->indexBy('nro_accidente')
            ->column();
        
        // Crear un dataProvider que solo muestre los registros únicos
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['registro.id_registro' => array_values($uniqueAccidents)]);
        
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
        $model = $this->findModel($id_registro);
        
        // Obtener todos los registros con el mismo número de accidente
        $relatedAccidents = Registro::find()
            ->where(['nro_accidente' => $model->nro_accidente])
            ->all();
        
        return $this->render('view', [
            'model' => $model,
            'relatedAccidents' => $relatedAccidents,
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
                    $model->id_estatus_proceso = 6;
                    $model->GenerarNumeroAccidente();

                    // Naturalezas
                    $naturalezaPrincipal = $model->id_naturaleza_accidente;
                    $naturalezaAdicional = $this->request->post('naturaleza_adicional'); // desde JS

                    // Manejo supervisor
                    if ($naturalezaPrincipal == 31 || $naturalezaPrincipal == 35) {
                        if (!$modelSupervisor->load($this->request->post()) || !$modelSupervisor->save()) {
                            throw new \yii\db\Exception('Error al guardar supervisor');
                        }
                        $model->cedula_supervisor_60min = $modelSupervisor->cedula;
                    }

                    // Datos de personas
                    $personasData = $this->request->post('PersonaNatural', []);
                    $cedulasPersonal = $this->request->post('Registro', [])['cedula_pers_accide'] ?? [];

                    // Guardar registro principal
                    if (!empty($cedulasPersonal[0])) {
                        $model->cedula_pers_accide = $cedulasPersonal[0];
                    } elseif (!empty($personasData[0]['cedula'])) {
                        $model->cedula_pers_accide = $personasData[0]['cedula'];
                    }

                    if (!$model->save(false)) {
                        throw new \yii\db\Exception('Error al guardar registro principal: ' . json_encode($model->errors));
                    }

                    // Si hay naturaleza adicional
                    if ($naturalezaAdicional) {
                        $registroAdicional = new Registro();
                        $registroAdicional->attributes = $model->attributes;
                        $registroAdicional->id_registro = null; // Nuevo registro
                        $registroAdicional->id_naturaleza_accidente = $naturalezaAdicional;
                        $registroAdicional->nro_accidente = $model->nro_accidente;
                    
                        if (in_array($naturalezaAdicional, [31, 35])) {
                            if (!empty($personasData[1]['cedula'])) {
                                $registroAdicional->cedula_pers_accide = $personasData[1]['cedula'];
                            }
                        } else {
                            if (!empty($cedulasPersonal[1])) {
                                $registroAdicional->cedula_pers_accide = $cedulasPersonal[1];
                            }
                        }
                    
                        if (!$registroAdicional->save(false)) {
                            throw new \yii\db\Exception('Error al guardar registro adicional: ' . json_encode($registroAdicional->errors));
                        }
                    
                        // Guardar PersonaNatural asociada si aplica
                        if (in_array($naturalezaAdicional, [31, 35])) {
                            if (!empty($personasData[1]['cedula'])) {
                                $personaNatural = new PersonaNatural();
                                $personaNatural->attributes = $personasData[1];
                                $personaNatural->id_registro = $registroAdicional->id_registro; // Asignamos el ID recién creado
                                if (!$personaNatural->save()) {
                                    throw new \yii\db\Exception('Error al guardar Persona Natural adicional: ' . json_encode($personaNatural->errors));
                                }
                            }
                        }
                    
                        // Guardar relación en RegistroAdicional
                        $registroRelacion = new RegistroAdicional();
                        $registroRelacion->id_registro = $model->id_registro;
                        $registroRelacion->nro_accidente = $registroAdicional->nro_accidente;
                        $registroRelacion->id_naturaleza_accidente = $registroAdicional->id_naturaleza_accidente;
                        $registroRelacion->id_estatus_proceso = $registroAdicional->id_estatus_proceso;
                        $registroRelacion->id_magnitud = $registroAdicional->id_magnitud;
                        $registroRelacion->acciones_tomadas_60min = $registroAdicional->acciones_tomadas_60min;
                    
                        if (!$registroRelacion->save()) {
                            throw new \yii\db\Exception('Error al guardar relación adicional: ' . json_encode($registroRelacion->errors));
                        }
                    }

                    $transaction->commit();
                    Yii::$app->session->setFlash('success', 'Registros guardados correctamente. N° Accidente: ' . $model->nro_accidente);
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
            'personalData' => $personalData, // Pasar personalData a la vista
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