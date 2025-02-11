<?php

namespace app\controllers;

use Yii;
use app\models\Cargo;
use app\models\CargoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * CargoController implements the CRUD actions for Cargo model.
 */
class CargoController extends Controller
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
                        ['actions' => ['index'], 'allow' => true, 'roles' => ['cargo/index']],
                        ['actions' => ['create'], 'allow' => true, 'roles' => ['cargo/create']],
                        ['actions' => ['update'], 'allow' => true, 'roles' => ['cargo/update']],
                        ['actions' => ['delete'], 'allow' => true, 'roles' => ['cargo/delete']],
                        ['actions' => ['permisos'], 'allow' => true, 'roles' => ['cargo/permisos']],
                    ]
                ]
            ]
        );
    }

    /**
     * Lists all Cargo models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new CargoSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Cargo model.
     * @param int $id_cargo Id Cargo
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_cargo)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_cargo),
        ]);
    }

    /**
     * Creates a new Cargo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Cargo();
        $model->scenario = Cargo::SCENARIO_CREATE;

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('success', 'Se ha creado exitosamente.');
                return $this->redirect(['index', 'id_cargo' => $model->id_cargo]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);

        
    }

    /**
     * Updates an existing Cargo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_cargo Id Cargo
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_cargo)
    {
        $model = $this->findModel($id_cargo);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Actualizacion exitosa.');
            return $this->redirect(['index', 'id_cargo' => $model->id_cargo]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Cargo model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_cargo Id Cargo
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_cargo)
    {
        //Eliminacion lógica
        $model = $this->findModel($id_cargo);
        $model->id_estatus = 2;
        $model->save(false);
        Yii::$app->session->setFlash('success', 'Se ha eliminado exitosamente.');

        return $this->redirect(['index']);
    }

    public function actionToggleStatus($id_cargo)
    {
        $model = $this->findModel($id_cargo);
        $model->id_estatus = ($model->id_estatus == 1) ? 2 : 1;
        $model->save(false); // Guardar sin validar
        return $this->redirect(['index']);
    }

    /**
     * Finds the Cargo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_cargo Id Cargo
     * @return Cargo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_cargo)
    {
        if (($model = Cargo::findOne(['id_cargo' => $id_cargo])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
