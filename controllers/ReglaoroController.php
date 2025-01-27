<?php

namespace app\controllers;
use Yii;
use app\models\ReglaOro;
use app\models\ReglaoroSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

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
                        ['actions' => ['index'], 'allow' => true, 'roles' => ['reglaoro/index']],
                        ['actions' => ['create'], 'allow' => true, 'roles' => ['reglaoro/create']],
                        ['actions' => ['update'], 'allow' => true, 'roles' => ['reglaoro/update']],
                        ['actions' => ['delete'], 'allow' => true, 'roles' => ['reglaoro/delete']],
                        ['actions' => ['permisos'], 'allow' => true, 'roles' => ['reglaoro/permisos']],
                    ]
                ]
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
        $model->scenario = ReglaOro::SCENARIO_CREATE;


        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('success', 'Se ha creado exitosamente.');
                return $this->redirect(['index', 'id_regla_oro' => $model->id_regla_oro]);
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
            Yii::$app->session->setFlash('success', 'Actualizacion exitosa.');
            return $this->redirect(['index', 'id_regla_oro' => $model->id_regla_oro]);
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
           //Eliminacion lógica
           $model = $this->findModel($id_regla_oro);
           $model->id_estatus = 2;
           $model->save(false);

        Yii::$app->session->setFlash('success', 'Se ha eliminado exitosamente.');
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
