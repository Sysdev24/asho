<?php

namespace app\controllers;

use app\models\Registro;
use app\models\RegistroSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * RegistroController implements the CRUD actions for Registro model.
 */
class RegistroController extends Controller
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
                        ['actions' => ['index'], 'allow' => true, 'roles' => ['registro/index']],
                        ['actions' => ['create'], 'allow' => true, 'roles' => ['registro/create']],
                        ['actions' => ['update'], 'allow' => true, 'roles' => ['registro/update']],
                        ['actions' => ['delete'], 'allow' => true, 'roles' => ['registro/delete']],
                        ['actions' => ['permisos'], 'allow' => true, 'roles' => ['registro/permisos']],
                    ]
                ]
            ]
        );
    }

    /**
     * Lists all Registro models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new RegistroSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Registro model.
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
     * Creates a new Registro model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Registro();

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
     * Updates an existing Registro model.
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
     * Deletes an existing Registro model.
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
     * Finds the Registro model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_registro Id Registro
     * @return Registro the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_registro)
    {
        if (($model = Registro::findOne(['id_registro' => $id_registro])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
