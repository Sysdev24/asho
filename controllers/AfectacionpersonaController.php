<?php

namespace app\controllers;

use app\models\AfectacionPersona;
use app\models\AfectacionpersonaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AfectacionpersonaController implements the CRUD actions for AfectacionPersona model.
 */
class AfectacionpersonaController extends Controller
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
     * Lists all AfectacionPersona models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new AfectacionpersonaSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AfectacionPersona model.
     * @param int $id_area_afectada Id Area Afectada
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_area_afectada)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_area_afectada),
        ]);
    }

    /**
     * Creates a new AfectacionPersona model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new AfectacionPersona();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id_area_afectada' => $model->id_area_afectada]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing AfectacionPersona model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_area_afectada Id Area Afectada
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_area_afectada)
    {
        $model = $this->findModel($id_area_afectada);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id_area_afectada' => $model->id_area_afectada]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing AfectacionPersona model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_area_afectada Id Area Afectada
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_area_afectada)
    {
        $this->findModel($id_area_afectada)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the AfectacionPersona model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_area_afectada Id Area Afectada
     * @return AfectacionPersona the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_area_afectada)
    {
        if (($model = AfectacionPersona::findOne(['id_area_afectada' => $id_area_afectada])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
