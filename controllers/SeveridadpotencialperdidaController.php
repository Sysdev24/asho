<?php

namespace app\controllers;
use Yii;
use app\models\SeveridadPotencialPerdida;
use app\models\SeveridadpotencialperdidaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * SeveridadpotencialperdidaController implements the CRUD actions for SeveridadPotencialPerdida model.
 */
class SeveridadpotencialperdidaController extends Controller
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
                        ['actions' => ['index'], 'allow' => true, 'roles' => ['severidadpotencialperdida/index']],
                        ['actions' => ['create'], 'allow' => true, 'roles' => ['severidadpotencialperdida/create']],
                        ['actions' => ['update'], 'allow' => true, 'roles' => ['severidadpotencialperdida/update']],
                        ['actions' => ['delete'], 'allow' => true, 'roles' => ['severidadpotencialperdida/delete']],
                        ['actions' => ['permisos'], 'allow' => true, 'roles' => ['severidadpotencialperdida/permisos']],
                    ]
                ]
            ]
        );
    }

    /**
     * Lists all SeveridadPotencialPerdida models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new SeveridadpotencialperdidaSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SeveridadPotencialPerdida model.
     * @param int $id_sev_pot_per Id Sev Pot Per
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_sev_pot_per)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_sev_pot_per),
        ]);
    }

    /**
     * Creates a new SeveridadPotencialPerdida model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new SeveridadPotencialPerdida();
        $model->scenario = SeveridadPotencialPerdida::SCENARIO_CREATE;


        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('success', 'Se ha creado exitosamente.');
                return $this->redirect(['index', 'id_sev_pot_per' => $model->id_sev_pot_per]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing SeveridadPotencialPerdida model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_sev_pot_per Id Sev Pot Per
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_sev_pot_per)
    {
        $model = $this->findModel($id_sev_pot_per);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Actualizacion exitosa.');
              return $this->redirect(['index', 'id_sev_pot_per' => $model->id_sev_pot_per]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing SeveridadPotencialPerdida model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_sev_pot_per Id Sev Pot Per
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_sev_pot_per)
    {
           //Eliminacion lógica
           $model = $this->findModel($id_sev_pot_per);
           $model->id_estatus = 2;
           $model->save(false);

        Yii::$app->session->setFlash('success', 'Se ha eliminado exitosamente.');
        return $this->redirect(['index']);
    }

    /**
     * Finds the SeveridadPotencialPerdida model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_sev_pot_per Id Sev Pot Per
     * @return SeveridadPotencialPerdida the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_sev_pot_per)
    {
        if (($model = SeveridadPotencialPerdida::findOne(['id_sev_pot_per' => $id_sev_pot_per])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
