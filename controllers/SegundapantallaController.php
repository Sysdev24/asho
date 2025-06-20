<?php

namespace app\controllers;

use app\models\SegundaPantalla;
use app\models\SegundapantallaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;


/**
 * SegundapantallaController implements the CRUD actions for SegundaPantalla model.
 */
class SegundapantallaController extends Controller
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
                        ['actions' => ['index'], 'allow' => true, 'roles' => ['segundapantalla/index']],
                        ['actions' => ['create'], 'allow' => true, 'roles' => ['segundapantalla/create']],
                        ['actions' => ['update'], 'allow' => true, 'roles' => ['segundapantalla/update']],
                        ['actions' => ['delete'], 'allow' => true, 'roles' => ['segundapantalla/delete']],
                        ['actions' => ['permisos'], 'allow' => true, 'roles' => ['segundapantalla/permisos']],
                    ]
                ]
            ]
        );
    }

    /**
     * Lists all SegundaPantalla models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new SegundapantallaSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SegundaPantalla model.
     * @param int $id_registro Id Registro
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_registro)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_registro),
        ]);
    }

    /**
     * Creates a new SegundaPantalla model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new SegundaPantalla();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id_registro' => $model->id_registro]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing SegundaPantalla model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_registro Id Registro
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_registro)
    {
        $model = $this->findModel($id_registro);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id_registro' => $model->id_registro]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing SegundaPantalla model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_registro Id Registro
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_registro)
    {
        $this->findModel($id_registro)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the SegundaPantalla model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_registro Id Registro
     * @return SegundaPantalla the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_registro)
    {
        if (($model = SegundaPantalla::findOne(['id_registro' => $id_registro])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
