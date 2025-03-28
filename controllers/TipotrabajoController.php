<?php

namespace app\controllers;

use Yii;
use app\models\TipoTrabajo;
use app\models\TipotrabajoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * TipotrabajoController implements the CRUD actions for TipoTrabajo model.
 */
class TipotrabajoController extends Controller
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
                        ['actions' => ['index'], 'allow' => true, 'roles' => ['tipotrabajo/index']],
                        ['actions' => ['create'], 'allow' => true, 'roles' => ['tipotrabajo/create']],
                        ['actions' => ['update'], 'allow' => true, 'roles' => ['tipotrabajo/update']],
                        ['actions' => ['delete'], 'allow' => true, 'roles' => ['tipotrabajo/delete']],
                        ['actions' => ['permisos'], 'allow' => true, 'roles' => ['tipotrabajo/permisos']],
                    ]
                ]
            ]
        );
    }

    /**
     * Lists all TipoTrabajo models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new TipotrabajoSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TipoTrabajo model.
     * @param int $id_tipo_trabajo Id Tipo Trabajo
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_tipo_trabajo)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_tipo_trabajo),
        ]);
    }

    /**
     * Creates a new TipoTrabajo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new TipoTrabajo();
        $model->scenario = TipoTrabajo::SCENARIO_CREATE;

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('success', 'Se ha creado exitosamente.');
                return $this->redirect(['index', 'id_tipo_trabajo' => $model->id_tipo_trabajo]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TipoTrabajo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_tipo_trabajo Id Tipo Trabajo
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_tipo_trabajo)
    {
        $model = $this->findModel($id_tipo_trabajo);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Actualizacion exitosa.');
            return $this->redirect(['index', 'id_tipo_trabajo' => $model->id_tipo_trabajo]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing TipoTrabajo model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_tipo_trabajo Id Tipo Trabajo
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_tipo_trabajo)
    {
           //Eliminacion lógica
           $model = $this->findModel($id_tipo_trabajo);
           $model->id_estatus = 2;
           $model->save(false);

        Yii::$app->session->setFlash('success', 'Se ha eliminado exitosamente.');
        return $this->redirect(['index']);
    }

    public function actionToggleStatus($id_tipo_trabajo)
    {
        $model = $this->findModel($id_tipo_trabajo);
        $model->id_estatus = ($model->id_estatus == 1) ? 2 : 1;
        $model->save(false); // Guardar sin validar
        return $this->redirect(['index']);
    }

    /**
     * Finds the TipoTrabajo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_tipo_trabajo Id Tipo Trabajo
     * @return TipoTrabajo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_tipo_trabajo)
    {
        if (($model = TipoTrabajo::findOne(['id_tipo_trabajo' => $id_tipo_trabajo])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
