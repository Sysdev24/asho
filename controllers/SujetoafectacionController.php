<?php

namespace app\controllers;

use app\models\Bienes;
use app\models\Personas;
use app\models\Procesos;
use app\models\Ambiente;

use Yii;
use app\models\SujetoAfectacion;
use app\models\SujetoAfectacionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SujetoafectacionController implements the CRUD actions for SujetoAfectacion model.
 */
class SujetoafectacionController extends Controller
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
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all SujetoAfectacion models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new SujetoAfectacionSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    //CONSULTA DE POSTGRES 
    public function actionPersonas()
    {
        $searchModel = new SujetoAfectacionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, 'personas');

        return $this->render('personas', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionBienes()
    {
        $searchModel = new SujetoAfectacionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, 'bienes');

        return $this->render('bienes', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionProcesos()
    {
        $searchModel = new SujetoAfectacionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, 'procesos');

        return $this->render('procesos', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionAmbiente()
    {
        $searchModel = new SujetoAfectacionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, 'ambiente');

        return $this->render('ambiente', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single SujetoAfectacion model.
     * @param int $id_sujeto_afect Id Sujeto Afect
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_sujeto_afect)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_sujeto_afect),
        ]);
    }

    /**
     * Creates a new SujetoAfectacion model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new SujetoAfectacion();
        $model->scenario = SujetoAfectacion::SCENARIO_CREATE;


        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('success', 'Se ha creado exitosamente.');
                return $this->redirect(['index', 'id_sujeto_afect' => $model->id_sujeto_afect]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionCreatePersonas()
    {
        $model = new Personas();
        $model->scenario = Personas::SCENARIO_CREATE;

        if ($model->load(Yii::$app->request->post())) {
            if ($model->guardar()) {
                Yii::$app->session->setFlash('success', 'Se ha creado exitosamente.');
                return $this->redirect(['personas']);
            } else {
                Yii::$app->session->setFlash('error', 'No se pudo crear el registro.');
            }
        }
    
        return $this->render('create-personas', [
            'model' => $model,
        ]);
    }

    public function actionCreateBienes()
    {
        $model = new Bienes();
        $model->scenario = Bienes::SCENARIO_CREATE;

        if ($model->load(Yii::$app->request->post())) {
            if ($model->guardar()) {
                Yii::$app->session->setFlash('success', 'Se ha creado exitosamente.');
                return $this->redirect(['personas']);
            } else {
                Yii::$app->session->setFlash('error', 'No se pudo crear el registro.');
            }
        }
    
        return $this->render('create-bienes', [
            'model' => $model,
        ]);
    }

    public function actionCreateProcesos()
    {
        $model = new Procesos();
        $model->scenario = Procesos::SCENARIO_CREATE;

        if ($model->load(Yii::$app->request->post())) {
            if ($model->guardar()) {
                Yii::$app->session->setFlash('success', 'Se ha creado exitosamente.');
                return $this->redirect(['procesos']);
            } else {
                Yii::$app->session->setFlash('error', 'No se pudo crear el registro.');
            }
        }
    
        return $this->render('create-procesos', [
            'model' => $model,
        ]);
    }

    public function actionCreateAmbiente()
    {
        $model = new Ambiente();
        $model->scenario = Ambiente::SCENARIO_CREATE;

        if ($model->load(Yii::$app->request->post())) {
            if ($model->guardar()) {
                Yii::$app->session->setFlash('success', 'Se ha creado exitosamente.');
                return $this->redirect(['ambiente']);
            } else {
                Yii::$app->session->setFlash('error', 'No se pudo crear el registro.');
            }
        }
    
        return $this->render('create-ambiente', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing SujetoAfectacion model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_sujeto_afect Id Sujeto Afect
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_sujeto_afect)
    {
        $model = $this->findModel($id_sujeto_afect);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Actualizacion exitosa.');
            return $this->redirect(['index', 'id_sujeto_afect' => $model->id_sujeto_afect]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionUpdatePersonas($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Actualizacion exitosa.');
            return $this->redirect(['personas']);
        }

        return $this->render('update-personas',  
        [
            'model' => $model,
        ]);
    }

    public function actionUpdateBienes($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Actualizacion exitosa.');
            return $this->redirect(['bienes']);
        }

        return $this->render('update-bienes',  
        [
            'model' => $model,
        ]);
    }

    public function actionUpdateProcesos($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Actualizacion exitosa.');
            return $this->redirect(['procesos']);
        }

        return $this->render('update-procesos',  
        [
            'model' => $model,
        ]);
    }

    public function actionUpdateAmbiente($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Actualizacion exitosa.');
            return $this->redirect(['ambiente']);
        }

        return $this->render('update-ambiente',  
        [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing SujetoAfectacion model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_sujeto_afect Id Sujeto Afect
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_sujeto_afect)
    {
        $this->findModel($id_sujeto_afect)->delete();
        Yii::$app->session->setFlash('success', 'Se ha eliminado exitosamente.');
        return $this->redirect(['index']);
    }

    public function actionDeletePersonas($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', 'Se ha eliminado exitosamente.');

        return $this->redirect(['personas']);
    }

    public function actionDeleteBienes($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', 'Se ha eliminado exitosamente.');

        return $this->redirect(['bienes']);
    }

    public function actionDeleteProcesos($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', 'Se ha eliminado exitosamente.');

        return $this->redirect(['procesos']);
    }

    public function actionDeleteAmbiente($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', 'Se ha eliminado exitosamente.');

        return $this->redirect(['ambiente']);
    }

    /**
     * Finds the SujetoAfectacion model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_sujeto_afect Id Sujeto Afect
     * @return SujetoAfectacion the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_sujeto_afect)
    {
        if (($model = SujetoAfectacion::findOne(['id_sujeto_afect' => $id_sujeto_afect])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
