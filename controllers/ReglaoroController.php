<?php

namespace app\controllers;

use app\models\ReglaOro;
use app\models\ReglaoroSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ReglaoroController implements the CRUD actions for ReglaOro model.
 */
class ReglaoroController extends Controller
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
     * Lists all ReglaOro models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ReglaoroSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ReglaOro model.
     * @param int $id_regla_oro Id Regla Oro
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_regla_oro)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_regla_oro),
        ]);
    }

    /**
     * Creates a new ReglaOro model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new ReglaOro();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id_regla_oro' => $model->id_regla_oro]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ReglaOro model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_regla_oro Id Regla Oro
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_regla_oro)
    {
        $model = $this->findModel($id_regla_oro);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id_regla_oro' => $model->id_regla_oro]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ReglaOro model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_regla_oro Id Regla Oro
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_regla_oro)
    {
        $this->findModel($id_regla_oro)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ReglaOro model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_regla_oro Id Regla Oro
     * @return ReglaOro the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_regla_oro)
    {
        if (($model = ReglaOro::findOne(['id_regla_oro' => $id_regla_oro])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
