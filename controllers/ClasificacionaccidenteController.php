<?php

namespace app\controllers;
use Yii;
use app\models\ClasificacionAccidente;
use app\models\ClasificacionaccidenteSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * ClasificacionaccidenteController implements the CRUD actions for ClasificacionAccidente model.
 */
class ClasificacionaccidenteController extends Controller
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
                        ['actions' => ['index'], 'allow' => true, 'roles' => ['clasificacionaccidente/index']],
                        ['actions' => ['create'], 'allow' => true, 'roles' => ['clasificacionaccidente/create']],
                        ['actions' => ['update'], 'allow' => true, 'roles' => ['clasificacionaccidente/update']],
                        ['actions' => ['delete'], 'allow' => true, 'roles' => ['clasificacionaccidente/delete']],
                        ['actions' => ['permisos'], 'allow' => true, 'roles' => ['clasificacionaccidente/permisos']],
                    ]
                ]
            ]
        );
    }

    /**
     * Lists all ClasificacionAccidente models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ClasificacionaccidenteSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ClasificacionAccidente model.
     * @param int $id_clasif_accid_lab_ope_amb Id Clasif Accid Lab Ope Amb
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_clasif_accid_lab_ope_amb)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_clasif_accid_lab_ope_amb),
        ]);
    }

    /**
     * Creates a new ClasificacionAccidente model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new ClasificacionAccidente();
        $model->scenario = ClasificacionAccidente::SCENARIO_CREATE;
        

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('success', 'Se ha creado exitosamente.');
                return $this->redirect(['index', 'id_clasif_accid_lab_ope_amb' => $model->id_clasif_accid_lab_ope_amb]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ClasificacionAccidente model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_clasif_accid_lab_ope_amb Id Clasif Accid Lab Ope Amb
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_clasif_accid_lab_ope_amb)
    {
        $model = $this->findModel($id_clasif_accid_lab_ope_amb);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Actualizacion exitosa.');
            return $this->redirect(['index', 'id_clasif_accid_lab_ope_amb' => $model->id_clasif_accid_lab_ope_amb]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ClasificacionAccidente model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_clasif_accid_lab_ope_amb Id Clasif Accid Lab Ope Amb
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_clasif_accid_lab_ope_amb)
    {
           //Eliminacion lógica
           $model = $this->findModel($id_clasif_accid_lab_ope_amb);
           $model->id_estatus = 2;
           $model->save(false);
        
        Yii::$app->session->setFlash('success', 'Se ha eliminado exitosamente.');

        return $this->redirect(['index']);
    }

    /**
     * Finds the ClasificacionAccidente model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_clasif_accid_lab_ope_amb Id Clasif Accid Lab Ope Amb
     * @return ClasificacionAccidente the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_clasif_accid_lab_ope_amb)
    {
        if (($model = ClasificacionAccidente::findOne(['id_clasif_accid_lab_ope_amb' => $id_clasif_accid_lab_ope_amb])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
