<?php

namespace app\controllers;

use Yii;
use app\models\Estados;
use app\models\EstadosSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * EstadosController implements the CRUD actions for Estados model.
 */
class EstadosController extends Controller
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
                        ['actions' => ['index'], 'allow' => true, 'roles' => ['estados/index']],
                        ['actions' => ['create'], 'allow' => true, 'roles' => ['estados/create']],
                        ['actions' => ['update'], 'allow' => true, 'roles' => ['estados/update']],
                        ['actions' => ['delete'], 'allow' => true, 'roles' => ['estados/delete']],
                        ['actions' => ['permisos'], 'allow' => true, 'roles' => ['estados/permisos']],
                    ]
                ]
            ]
        );
    }

    /**
     * Lists all Estados models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new EstadosSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Estados model.
     * @param int $id_estado Id Estado
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_estado)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_estado),
        ]);
    }

    /**
     * Creates a new Estados model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Estados();
        $model->scenario = Estados::SCENARIO_CREATE;


        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('success', 'Se ha creado exitosamente.');
                return $this->redirect(['index', 'id_estado' => $model->id_estado]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Estados model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_estado Id Estado
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_estado)
    {
        $model = $this->findModel($id_estado);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Actualizacion exitosa.');
            return $this->redirect(['index', 'id_estado' => $model->id_estado]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Estados model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_estado Id Estado
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_estado)
    {
           //Eliminacion lógica
           $model = $this->findModel($id_estado);
           $model->id_estatus = 2;
           $model->save(false);
        
        Yii::$app->session->setFlash('success', 'Se ha eliminado exitosamente.');

        return $this->redirect(['index']);
    }

    /**
     * Finds the Estados model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_estado Id Estado
     * @return Estados the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_estado)
    {
        if (($model = Estados::findOne(['id_estado' => $id_estado])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
