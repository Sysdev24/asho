<?php

namespace app\controllers;
use Yii;
use app\models\NaturalezaAccidente;
use app\models\NaturalezaaccidenteSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * NaturalezaaccidenteController implements the CRUD actions for NaturalezaAccidente model.
 */
class NaturalezaaccidenteController extends Controller
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
     * Lists all NaturalezaAccidente models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new NaturalezaaccidenteSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single NaturalezaAccidente model.
     * @param int $id_naturaleza_accidente Id Naturaleza Accidente
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_naturaleza_accidente)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_naturaleza_accidente),
        ]);
    }

    /**
     * Creates a new NaturalezaAccidente model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new NaturalezaAccidente();
        $model->scenario = NaturalezaAccidente::SCENARIO_CREATE;


        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('success', 'Se ha creado exitosamente.');
                return $this->redirect(['index', 'id_naturaleza_accidente' => $model->id_naturaleza_accidente]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing NaturalezaAccidente model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_naturaleza_accidente Id Naturaleza Accidente
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_naturaleza_accidente)
    {
        $model = $this->findModel($id_naturaleza_accidente);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Actualizacion exitosa.');
            return $this->redirect(['index', 'id_naturaleza_accidente' => $model->id_naturaleza_accidente]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing NaturalezaAccidente model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_naturaleza_accidente Id Naturaleza Accidente
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_naturaleza_accidente)
    {
        $this->findModel($id_naturaleza_accidente)->delete();
        Yii::$app->session->setFlash('success', 'Se ha eliminado exitosamente.');
        return $this->redirect(['index']);
    }

    /**
     * Finds the NaturalezaAccidente model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_naturaleza_accidente Id Naturaleza Accidente
     * @return NaturalezaAccidente the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_naturaleza_accidente)
    {
        if (($model = NaturalezaAccidente::findOne(['id_naturaleza_accidente' => $id_naturaleza_accidente])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
