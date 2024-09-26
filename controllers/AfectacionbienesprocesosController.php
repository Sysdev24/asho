<?php

namespace app\controllers;

use Yii;
use app\models\AfectacionBienesProcesos;
use app\models\AfectacionbienesprocesosSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AfectacionbienesprocesosController implements the CRUD actions for AfectacionBienesProcesos model.
 */
class AfectacionbienesprocesosController extends Controller
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
     * Lists all AfectacionBienesProcesos models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new AfectacionbienesprocesosSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AfectacionBienesProcesos model.
     * @param int $id_afec_bien_pro Id Afec Bien Pro
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_afec_bien_pro)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_afec_bien_pro),
        ]);
    }

    /**
     * Creates a new AfectacionBienesProcesos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new AfectacionBienesProcesos();
        $model->scenario = AfectacionBienesProcesos::SCENARIO_CREATE;


        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('success', 'Se ha creado exitosamente.');
                return $this->redirect(['index', 'id_afec_bien_pro' => $model->id_afec_bien_pro]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing AfectacionBienesProcesos model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_afec_bien_pro Id Afec Bien Pro
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_afec_bien_pro)
    {
        $model = $this->findModel($id_afec_bien_pro);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Actualizacion exitosa.');
            return $this->redirect(['index', 'id_afec_bien_pro' => $model->id_afec_bien_pro]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing AfectacionBienesProcesos model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_afec_bien_pro Id Afec Bien Pro
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_afec_bien_pro)
    {
        $this->findModel($id_afec_bien_pro)->delete();
        Yii::$app->session->setFlash('success', 'Se ha eliminado exitosamente.');
        return $this->redirect(['index']);
    }

    /**
     * Finds the AfectacionBienesProcesos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_afec_bien_pro Id Afec Bien Pro
     * @return AfectacionBienesProcesos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_afec_bien_pro)
    {
        if (($model = AfectacionBienesProcesos::findOne(['id_afec_bien_pro' => $id_afec_bien_pro])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
