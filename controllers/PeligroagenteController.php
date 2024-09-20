<?php

namespace app\controllers;
use Yii;
use app\models\PeligroAgente;
use app\models\PeligroagenteSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PeligroagenteController implements the CRUD actions for PeligroAgente model.
 */
class PeligroagenteController extends Controller
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
     * Lists all PeligroAgente models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new PeligroagenteSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PeligroAgente model.
     * @param int $id_pel_agen Id Pel Agen
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_pel_agen)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_pel_agen),
        ]);
    }

    /**
     * Creates a new PeligroAgente model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new PeligroAgente();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('success', 'Se ha creado exitosamente.');
                return $this->redirect(['view', 'id_pel_agen' => $model->id_pel_agen]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing PeligroAgente model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_pel_agen Id Pel Agen
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_pel_agen)
    {
        $model = $this->findModel($id_pel_agen);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id_pel_agen' => $model->id_pel_agen]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing PeligroAgente model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_pel_agen Id Pel Agen
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_pel_agen)
    {
        $this->findModel($id_pel_agen)->delete();
        Yii::$app->session->setFlash('success', 'Se ha eliminado exitosamente.');
        return $this->redirect(['index']);
    }

    /**
     * Finds the PeligroAgente model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_pel_agen Id Pel Agen
     * @return PeligroAgente the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_pel_agen)
    {
        if (($model = PeligroAgente::findOne(['id_pel_agen' => $id_pel_agen])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
