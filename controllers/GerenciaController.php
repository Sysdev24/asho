<?php

namespace app\controllers;
use Yii;
use app\models\Gerencia;
use app\models\GerenciaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * GerenciaController implements the CRUD actions for Gerencia model.
 */
class GerenciaController extends Controller
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
                        ['actions' => ['index'], 'allow' => true, 'roles' => ['gerencia/index']],
                        ['actions' => ['create'], 'allow' => true, 'roles' => ['gerencia/create']],
                        ['actions' => ['update'], 'allow' => true, 'roles' => ['gerencia/update']],
                        ['actions' => ['delete'], 'allow' => true, 'roles' => ['gerencia/delete']],
                        ['actions' => ['permisos'], 'allow' => true, 'roles' => ['gerencia/permisos']],
                    ]
                ]
            ]
        );
    }

    /**
     * Lists all Gerencia models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new GerenciaSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Gerencia model.
     * @param int $id_gerencia Id Gerencia
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_gerencia)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_gerencia),
        ]);
    }

    /**
     * Creates a new Gerencia model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Gerencia();
        $model->scenario = Gerencia::SCENARIO_CREATE;


        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('success', 'Se ha creado exitosamente.');
                return $this->redirect(['index', 'id_gerencia' => $model->id_gerencia]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Gerencia model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_gerencia Id Gerencia
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_gerencia)
    {
        $model = $this->findModel($id_gerencia);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Actualizacion exitosa.');
            return $this->redirect(['index', 'id_gerencia' => $model->id_gerencia]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Gerencia model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_gerencia Id Gerencia
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_gerencia)
    {
        $this->findModel($id_gerencia)->delete();
        Yii::$app->session->setFlash('success', 'Se ha eliminado exitosamente.');

        return $this->redirect(['index']);
    }

    /**
     * Finds the Gerencia model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_gerencia Id Gerencia
     * @return Gerencia the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_gerencia)
    {
        if (($model = Gerencia::findOne(['id_gerencia' => $id_gerencia])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
