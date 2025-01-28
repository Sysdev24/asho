<?php

namespace app\controllers;

use app\models\RegistroReglaOro;
use app\models\RegistroreglaoroSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * RegistroreglaoroController implements the CRUD actions for RegistroReglaOro model.
 */
class RegistroreglaoroController extends Controller
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
                        ['actions' => ['index'], 'allow' => true, 'roles' => ['registroreglaoro/index']],
                        ['actions' => ['create'], 'allow' => true, 'roles' => ['registroreglaoro/create']],
                        ['actions' => ['update'], 'allow' => true, 'roles' => ['registroreglaoro/update']],
                        ['actions' => ['delete'], 'allow' => true, 'roles' => ['registroreglaoro/delete']],
                        ['actions' => ['permisos'], 'allow' => true, 'roles' => ['registroreglaoro/permisos']],
                    ]
                ]
            ]
        );
    }

    /**
     * Lists all RegistroReglaOro models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new RegistroreglaoroSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single RegistroReglaOro model.
     * @param int $id_registro_regla_oro Id Registro Regla Oro
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_registro_regla_oro)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_registro_regla_oro),
        ]);
    }

    /**
     * Creates a new RegistroReglaOro model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new RegistroReglaOro();
        $model->scenario = RegistroReglaOro::SCENARIO_CREATE;


        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id_registro_regla_oro' => $model->id_registro_regla_oro]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing RegistroReglaOro model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_registro_regla_oro Id Registro Regla Oro
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_registro_regla_oro)
    {
        $model = $this->findModel($id_registro_regla_oro);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id_registro_regla_oro' => $model->id_registro_regla_oro]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing RegistroReglaOro model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_registro_regla_oro Id Registro Regla Oro
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_registro_regla_oro)
    {
          //Eliminacion lógica
          $model = $this->findModel($id_registro_regla_oro);
          $model->id_estatus = 2;
          $model->save(false);
        return $this->redirect(['index']);
    }

    /**
     * Finds the RegistroReglaOro model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_registro_regla_oro Id Registro Regla Oro
     * @return RegistroReglaOro the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_registro_regla_oro)
    {
        if (($model = RegistroReglaOro::findOne(['id_registro_regla_oro' => $id_registro_regla_oro])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
