<?php

namespace app\controllers;
use Yii;
use app\models\Estatus;
use app\models\EstatusSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * EstatusController implements the CRUD actions for Estatus model.
 */
class EstatusController extends Controller
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
                        ['actions' => ['index'], 'allow' => true, 'roles' => ['estatus/index']],
                        ['actions' => ['create'], 'allow' => true, 'roles' => ['estatus/create']],
                        ['actions' => ['update'], 'allow' => true, 'roles' => ['estatus/update']],
                        ['actions' => ['delete'], 'allow' => true, 'roles' => ['estatus/delete']],
                        ['actions' => ['permisos'], 'allow' => true, 'roles' => ['estatus/permisos']],
                    ]
                ]
            ]
        );
    }

    /**
     * Lists all Estatus models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new EstatusSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Estatus model.
     * @param int $id_estatus Id Estatus
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_estatus)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_estatus),
        ]);
    }

    /**
     * Creates a new Estatus model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Estatus();
        $model->scenario = Estatus::SCENARIO_CREATE;


        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('success', 'Se ha creado exitosamente.');
                return $this->redirect(['index', 'id_estatus' => $model->id_estatus]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Estatus model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_estatus Id Estatus
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_estatus)
    {
        $model = $this->findModel($id_estatus);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Actualizacion exitosa.');
            return $this->redirect(['index', 'id_estatus' => $model->id_estatus]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Estatus model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_estatus Id Estatus
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_estatus)
    {
        $this->findModel($id_estatus)->delete();
        Yii::$app->session->setFlash('success', 'Se ha eliminado exitosamente.');
        return $this->redirect(['index']);
    }

    /**
     * Finds the Estatus model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_estatus Id Estatus
     * @return Estatus the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_estatus)
    {
        if (($model = Estatus::findOne(['id_estatus' => $id_estatus])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
