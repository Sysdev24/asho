<?php

namespace app\controllers;
use Yii;
use app\models\Regiones;
use app\models\RegionesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RegionesController implements the CRUD actions for Regiones model.
 */
class RegionesController extends Controller
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
     * Lists all Regiones models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new RegionesSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Regiones model.
     * @param int $id_regiones Id Regiones
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_regiones)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_regiones),
        ]);
    }

    /**
     * Creates a new Regiones model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Regiones();
        $model->scenario = Regiones::SCENARIO_CREATE;


        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('success', 'Se ha creado exitosamente.');
                return $this->redirect(['index', 'id_regiones' => $model->id_regiones]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Regiones model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_regiones Id Regiones
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_regiones)
    {
        $model = $this->findModel($id_regiones);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Actualizacion exitosa.');
            return $this->redirect(['index', 'id_regiones' => $model->id_regiones]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Regiones model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_regiones Id Regiones
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_regiones)
    {
        $this->findModel($id_regiones)->delete();
        Yii::$app->session->setFlash('success', 'Se ha eliminado exitosamente.');
        return $this->redirect(['index']);
    }

    /**
     * Finds the Regiones model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_regiones Id Regiones
     * @return Regiones the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_regiones)
    {
        if (($model = Regiones::findOne(['id_regiones' => $id_regiones])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
