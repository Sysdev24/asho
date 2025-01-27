<?php

namespace app\controllers;

use yii;
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

    if ($this->request->isPost) {
        if ($model->load($this->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                // Obtener el año en formato YY
                $year = date('y');

                // Buscar el último registro generado (si existe)
                $lastRegistro = Registro::find()
                    ->where(['like', 'nro_accidente', '0' . $year . '%', false])
                    ->orderBy(['nro_accidente' => SORT_DESC])
                    ->one();

                // Generar el correlativo
                if ($lastRegistro) {
                    // Extraer el último correlativo y convertir a entero
                    $lastCorrelativo = (int)substr($lastRegistro->nro_accidente, 3, 5);
                    // Incrementar el correlativo y formatearlo a 5 dígitos
                    $correlativo = str_pad($lastCorrelativo + 1, 5, '0', STR_PAD_LEFT);
                } else {
                    // Comenzar el primer correlativo
                    $correlativo = '00001';
                }

                // Obtener el código de la naturaleza de la lesión
                $naturalezaAccidente = NaturalezaAccidente::findOne($model->id_naturaleza_accidente);
                $codigoNaturaleza = $naturalezaAccidente !== null ? $naturalezaAccidente->codigo : '';

                // Generar el código completo (0 + año + correlativo + código naturaleza)
                $model->nro_accidente = '0' . $year . $correlativo . $codigoNaturaleza;
                $model->correlativo = $correlativo; // Asignar el correlativo al modelo

                // Guardar el registro con el nuevo código
                if (!$model->save(false)) {
                    throw new \yii\db\Exception('No se pudo guardar el registro: ' . json_encode($model->errors));
                }

                $transaction->commit();

                Yii::$app->session->setFlash('success', 'Registro guardado exitosamente. Código de accidente: ' . $model->nro_accidente);
                return $this->redirect(['index', 'id_registro' => $model->id_registro]);
            } catch (\Exception $e) {
                $transaction->rollBack();
                Yii::$app->session->setFlash('error', 'Error al guardar el registro: ' . $e->getMessage());
            }
        }
    } else {
        $model->loadDefaultValues();
    }

    return $this->render('create', [
        'model' => $model,
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

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Actualizacion exitosa.');
            return $this->redirect(['index', 'id_registro' => $model->id_registro]);
        }

        return $this->render('update', [
            'model' => $model,
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
           //Eliminacion lógica
           $model = $this->findModel($id_registro);
           $model->id_estatus = 2;
           $model->save(false);

        Yii::$app->session->setFlash('success', 'Se ha eliminado exitosamente.');
        return $this->redirect(['index']);
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
