<?php

namespace app\controllers;

use Yii;
use app\models\CausaInmediataDirectas;
use app\models\CausainmediatadirectasSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;


/**
 * CausainmediatadirectasController implements the CRUD actions for CausaInmediataDirectas model.
 */
class CausainmediatadirectasController extends Controller
{
    /**
     * @inheritDoc
     */
    // public function behaviors()
    // {
    //     return array_merge(
    //         parent::behaviors(),
    //         [
    //             'verbs' => [
    //                 'class' => VerbFilter::class,
    //                 'actions' => [
    //                     'delete' => ['POST'],
    //                 ],
    //             ],
    //             'access' => [
    //                 'class' => AccessControl::class,
    //                 'only' => [
    //                     'index', 'create', 'update', 'delete', 'permisos',
    //                 ], 
    //                 'rules' => [
    //                     ['actions' => ['index'], 'allow' => true, 'roles' => ['causainmediatadirectas/index']],
    //                     ['actions' => ['create'], 'allow' => true, 'roles' => ['causainmediatadirectas/create']],
    //                     ['actions' => ['update'], 'allow' => true, 'roles' => ['causainmediatadirectas/update']],
    //                     ['actions' => ['delete'], 'allow' => true, 'roles' => ['causainmediatadirectas/delete']],
    //                     ['actions' => ['permisos'], 'allow' => true, 'roles' => ['causainmediatadirectas/permisos']],
    //                 ]
    //             ]
    //         ]
    //     );
    // }

    /**
     * Lists all CausaInmediataDirectas models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new CausainmediatadirectasSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CausaInmediataDirectas model.
     * @param int $id_cau_inm_dir Id Cau Inm Dir
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_cau_inm_dir)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_cau_inm_dir),
        ]);
    }

    /**
     * Creates a new CausaInmediataDirectas model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new CausaInmediataDirectas();
        $model->scenario = CausaInmediataDirectas::SCENARIO_CREATE;


        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {

                Yii::$app->session->setFlash('success', 'Se ha creado exitosamente.');

                return $this->redirect(['view', 'id_cau_inm_dir' => $model->id_cau_inm_dir]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing CausaInmediataDirectas model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_cau_inm_dir Id Cau Inm Dir
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_cau_inm_dir)
    {
        $model = $this->findModel($id_cau_inm_dir);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {

            Yii::$app->session->setFlash('success', 'Actualizacion exitosa.');

            return $this->redirect(['view', 'id_cau_inm_dir' => $model->id_cau_inm_dir]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing CausaInmediataDirectas model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_cau_inm_dir Id Cau Inm Dir
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_estado)
    {
        $this->findModel($id_estado)->delete();
        
        Yii::$app->session->setFlash('success', 'Se ha eliminado exitosamente.');

        return $this->redirect(['index']);
    }

    /**
     * Finds the CausaInmediataDirectas model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_cau_inm_dir Id Cau Inm Dir
     * @return CausaInmediataDirectas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_cau_inm_dir)
    {
        if (($model = CausaInmediataDirectas::findOne(['id_cau_inm_dir' => $id_cau_inm_dir])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
