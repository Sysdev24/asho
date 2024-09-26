<?php

namespace app\controllers;
use Yii;
use app\models\TipoAccidente;
use app\models\TipoaccidenteSearch;
use app\models\TipoTrabajo;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TipoaccidenteController implements the CRUD actions for TipoAccidente model.
 */
class TipoaccidenteController extends Controller
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
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all TipoAccidente models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new TipoaccidenteSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TipoAccidente model.
     * @param int $id_tipo_accidente Id Tipo Accidente
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_tipo_accidente)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_tipo_accidente),
        ]);
    }

    /**
     * Creates a new TipoAccidente model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new TipoAccidente();
        $model->scenario = TipoAccidente::SCENARIO_CREATE;

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('success', 'Se ha creado exitosamente.');
                return $this->redirect(['index', 'id_tipo_accidente' => $model->id_tipo_accidente]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TipoAccidente model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_tipo_accidente Id Tipo Accidente
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_tipo_accidente)
    {
        $model = $this->findModel($id_tipo_accidente);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Actualizacion exitosa.');
            return $this->redirect(['index', 'id_tipo_accidente' => $model->id_tipo_accidente]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing TipoAccidente model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_tipo_accidente Id Tipo Accidente
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_tipo_accidente)
    {
        $this->findModel($id_tipo_accidente)->delete();
        Yii::$app->session->setFlash('success', 'Se ha eliminado exitosamente.');
        return $this->redirect(['index']);
    }

    /**
     * Finds the TipoAccidente model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_tipo_accidente Id Tipo Accidente
     * @return TipoAccidente the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_tipo_accidente)
    {
        if (($model = TipoAccidente::findOne(['id_tipo_accidente' => $id_tipo_accidente])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
