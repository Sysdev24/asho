<?php

namespace app\controllers;

use Yii;
use app\models\PersonaNatural;
use app\models\PersonanaturalSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * PersonanaturalController implements the CRUD actions for PersonaNatural model.
 */
class PersonanaturalController extends Controller
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
                        ['actions' => ['index'], 'allow' => true, 'roles' => ['personanatural/index']],
                        ['actions' => ['create'], 'allow' => true, 'roles' => ['personanatural/create']],
                        ['actions' => ['update'], 'allow' => true, 'roles' => ['personanatural/update']],
                        ['actions' => ['delete'], 'allow' => true, 'roles' => ['personanatural/delete']],
                        ['actions' => ['permisos'], 'allow' => true, 'roles' => ['personanatural/permisos']],
                    ]
                ]
            ]
        );
    }

    /**
     * Lists all PersonaNatural models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new PersonanaturalSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PersonaNatural model.
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
     * Creates a new PersonaNatural model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new PersonaNatural();
        $model->scenario = PersonaNatural::SCENARIO_CREATE;

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('success', 'Se ha creado exitosamente.');
                return $this->redirect(['view', 'ci' => $model->ci]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing PersonaNatural model.
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
            return $this->redirect(['view', 'ci' => $model->ci]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing PersonaNatural model.
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

    /**
     * Finds the PersonaNatural model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $ci Ci
     * @return PersonaNatural the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($ci)
    {
        if (($model = PersonaNatural::findOne(['ci' => $ci])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
