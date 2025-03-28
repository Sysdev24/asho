<?php

namespace app\controllers;
use Yii;
use app\models\Personal;
use app\models\PersonalSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;



/**
 * PersonalController implements the CRUD actions for Personal model.
 */
class PersonalController extends Controller
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
                        'view', 'index', 'create', 'update', 'delete', 'permisos',
                    ], 
                    'rules' => [
                        ['actions' => ['view'], 'allow' => true, 'roles' => ['personal/view']],
                        ['actions' => ['index'], 'allow' => true, 'roles' => ['personal/index']],
                        ['actions' => ['create'], 'allow' => true, 'roles' => ['personal/create']],
                        ['actions' => ['update'], 'allow' => true, 'roles' => ['personal/update']],
                        ['actions' => ['delete'], 'allow' => true, 'roles' => ['personal/delete']],
                        ['actions' => ['permisos'], 'allow' => true, 'roles' => ['personal/permisos']],
                    ]
                ]
            ]
        );
    }

    /**
     * Lists all Personal models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new PersonalSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Personal model.
     * @param int $ci Ci
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($ci)
    {
        return $this->render('view', [
            'model' => $this->findModel($ci),
        ]);
    }

    /**
     * Creates a new Personal model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Personal();
        $model->scenario = Personal::SCENARIO_CREATE;


        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('success', 'Se ha creado exitosamente.');
                return $this->redirect(['index', 'ci' => $model->ci]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Personal model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $ci Ci
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($ci)
    {
        $model = $this->findModel($ci);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Actualizacion exitosa.');
            return $this->redirect(['index', 'ci' => $model->ci]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Personal model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $ci Ci
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($ci)
    {
           //Eliminacion lógica
           $model = $this->findModel($ci);
           $model->id_estatus = 2;
           $model->save(false);

        Yii::$app->session->setFlash('success', 'Se ha eliminado exitosamente.');
        return $this->redirect(['index']);
    }

    public function actionToggleStatus($ci)
    {
        $model = $this->findModel($ci);
        
        if ($model->id_estatus == 1) {
            $model->id_estatus = 2; // Desactivar
            Yii::$app->session->setFlash('success', 'Se ha desactivado correctamente.');
        } else {
            $model->id_estatus = 1; // Activar
            Yii::$app->session->setFlash('success', 'Se ha activado correctamente.');
        }
        
        $model->save(false); // Guardar sin validar
        return $this->redirect(['index']);
    }


    /**
     * Finds the Personal model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $ci Ci
     * @return Personal the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($ci)
    {
        if (($model = Personal::findOne(['ci' => $ci])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
