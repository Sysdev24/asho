<?php

namespace app\controllers;

use Yii;
use app\models\Magnitud;
use app\models\MagnitudSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MagnitudController implements the CRUD actions for Magnitud model.
 */
class MagnitudController extends Controller
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
     * Lists all Magnitud models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new MagnitudSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Magnitud model.
     * @param int $id_magnitud Id Magnitud
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_magnitud)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_magnitud),
        ]);
    }

    /**
     * Creates a new Magnitud model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Magnitud();
        $model->scenario = Magnitud::SCENARIO_CREATE;
        

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('success', 'Se ha creado exitosamente.');
                return $this->redirect(['index', 'id_magnitud' => $model->id_magnitud]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Magnitud model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_magnitud Id Magnitud
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_magnitud)
    {
        $model = $this->findModel($id_magnitud);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Actualizacion exitosa.');
            return $this->redirect(['index', 'id_magnitud' => $model->id_magnitud]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Magnitud model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_magnitud Id Magnitud
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_magnitud)
    {
        $this->findModel($id_magnitud)->delete();
        Yii::$app->session->setFlash('success', 'Se ha eliminado exitosamente.');
        return $this->redirect(['index']);
    }

    /**
     * Finds the Magnitud model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_magnitud Id Magnitud
     * @return Magnitud the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_magnitud)
    {
        if (($model = Magnitud::findOne(['id_magnitud' => $id_magnitud])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
