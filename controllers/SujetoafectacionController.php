<?php

namespace app\controllers;
use Yii;
use app\models\SujetoAfectacion;
use app\models\SujetoAfectacionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SujetoafectacionController implements the CRUD actions for SujetoAfectacion model.
 */
class SujetoafectacionController extends Controller
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
     * Lists all SujetoAfectacion models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new SujetoAfectacionSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SujetoAfectacion model.
     * @param int $id_sujeto_afect Id Sujeto Afect
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_sujeto_afect)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_sujeto_afect),
        ]);
    }

    /**
     * Creates a new SujetoAfectacion model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new SujetoAfectacion();
        $model->scenario = SujetoAfectacion::SCENARIO_CREATE;


        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('success', 'Se ha creado exitosamente.');
                return $this->redirect(['index', 'id_sujeto_afect' => $model->id_sujeto_afect]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing SujetoAfectacion model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_sujeto_afect Id Sujeto Afect
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_sujeto_afect)
    {
        $model = $this->findModel($id_sujeto_afect);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Actualizacion exitosa.');
            return $this->redirect(['index', 'id_sujeto_afect' => $model->id_sujeto_afect]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing SujetoAfectacion model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_sujeto_afect Id Sujeto Afect
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_sujeto_afect)
    {
        $this->findModel($id_sujeto_afect)->delete();
        Yii::$app->session->setFlash('success', 'Se ha eliminado exitosamente.');
        return $this->redirect(['index']);
    }

    /**
     * Finds the SujetoAfectacion model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_sujeto_afect Id Sujeto Afect
     * @return SujetoAfectacion the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_sujeto_afect)
    {
        if (($model = SujetoAfectacion::findOne(['id_sujeto_afect' => $id_sujeto_afect])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
