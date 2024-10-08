<?php

namespace app\controllers;

use Yii;
use app\models\AfectacionPersona;
use app\models\AfectacionpersonaSearch;
use app\models\Area;
use app\models\Naturaleza;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\data\ActiveDataProvider;

/**
 * AfectacionpersonaController implements the CRUD actions for AfectacionPersona model.
 */
class AfectacionpersonaController extends Controller
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
     * Lists all AfectacionPersona models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new AfectacionpersonaSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    //CONSULTA DE POSTGRES 
    public function actionArea()
    {
        $searchModel = new AfectacionpersonaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, 'area');

        return $this->render('area', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionNaturaleza()
    {
        $searchModel = new AfectacionpersonaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, 'naturaleza');

        return $this->render('naturaleza', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }
    

    /**
     * Displays a single AfectacionPersona model.
     * @param int $id_area_afectada Id Area Afectada
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_area_afectada)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_area_afectada),
        ]);
    }

    /**
     * Creates a new AfectacionPersona model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new AfectacionPersona();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('success', 'Se ha creado exitosamente.');
                return $this->redirect(['view', 'id_area_afectada' => $model->id_area_afectada]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }


    public function actionCreateArea()
    {
        $model = new Area();
        $model->scenario = Area::SCENARIO_CREATE;

        if ($model->load(Yii::$app->request->post())) {
            if ($model->guardar()) {
                Yii::$app->session->setFlash('success', 'Se ha creado exitosamente.');
                return $this->redirect(['area']);
            } else {
                Yii::$app->session->setFlash('error', 'No se pudo crear el registro.');
            }
        }
    
        return $this->render('create-area', [
            'model' => $model,
        ]);
    }

    public function actionCreateNaturaleza()
    {
        $model = new Naturaleza();
        $model->scenario = Naturaleza::SCENARIO_CREATE;


        if ($model->load(Yii::$app->request->post())) {
            if ($model->guardar()) {
                Yii::$app->session->setFlash('success', 'Se ha creado exitosamente.');
                return $this->redirect(['naturaleza']);
            } else {
                Yii::$app->session->setFlash('error', 'No se pudo crear el registro.');
            }
        }

        return $this->render('create-naturaleza', [
            'model' => $model,
        ]);
    }

    

    /**
     * Updates an existing AfectacionPersona model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_area_afectada Id Area Afectada
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_area_afectada)
    {
        $model = $this->findModel($id_area_afectada);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id_area_afectada' => $model->id_area_afectada]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }


    public function actionUpdateArea($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Actualizacion exitosa.');
            return $this->redirect(['area']);
        }

        return $this->render('update-area',  
    [
            'model' => $model,
        ]);
    }

    public function actionUpdateNaturaleza($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Actualizacion exitosa.');
            return $this->redirect(['naturaleza']);
        }

        return $this->render('update-naturaleza',  
    [
            'model' => $model,
        ]);
    }



    /**
     * Deletes an existing AfectacionPersona model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_area_afectada Id Area Afectada
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_area_afectada)
    {
        $this->findModel($id_area_afectada)->delete();
        Yii::$app->session->setFlash('success', 'Se ha eliminado exitosamente.');

        return $this->redirect(['index']);
    }

    public function actionDeleteArea($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', 'Se ha eliminado exitosamente.');

        return $this->redirect(['area']);
    }

    public function actionDeleteNaturaleza($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', 'Se ha eliminado exitosamente.');

        return $this->redirect(['naturaleza']);
    }
    /**
     * Finds the AfectacionPersona model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_area_afectada Id Area Afectada
     * @return AfectacionPersona the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_area_afectada)
    {
        if (($model = AfectacionPersona::findOne(['id_area_afectada' => $id_area_afectada])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}


