<?php

namespace app\controllers;

use Yii;
use app\models\CausasCb;
use app\models\CausascbSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * CausascbController implements the CRUD actions for CausasCb model.
 */
class CausascbController extends Controller
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
    //                     ['actions' => ['index'], 'allow' => true, 'roles' => ['causascb/index']],
    //                     ['actions' => ['create'], 'allow' => true, 'roles' => ['causascb/create']],
    //                     ['actions' => ['update'], 'allow' => true, 'roles' => ['causascb/update']],
    //                     ['actions' => ['delete'], 'allow' => true, 'roles' => ['causascb/delete']],
    //                     ['actions' => ['permisos'], 'allow' => true, 'roles' => ['causascb/permisos']],
    //                 ]
    //             ]
    //         ]
    //     );
    // }

    /**
     * Lists all CausasCb models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new CausascbSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CausasCb model.
     * @param int $id_causas_cb Id Causas Cb
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_causas_cb)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_causas_cb),
        ]);
    }

    /**
     * Creates a new CausasCb model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new CausasCb();
        $model->scenario = CausasCb::SCENARIO_CREATE;

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {

                Yii::$app->session->setFlash('success', 'Se ha creado exitosamente.');

                return $this->redirect(['view', 'id_causas_cb' => $model->id_causas_cb]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing CausasCb model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_causas_cb Id Causas Cb
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_causas_cb)
    {
        $model = $this->findModel($id_causas_cb);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {

            Yii::$app->session->setFlash('success', 'Actualizacion exitosa.');

            return $this->redirect(['view', 'id_causas_cb' => $model->id_causas_cb]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing CausasCb model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_causas_cb Id Causas Cb
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_causas_cb)
    {
           //Eliminacion lógica
           $model = $this->findModel($id_causas_cb);
           $model->id_estatus = 2;
           $model->save(false);
        
        Yii::$app->session->setFlash('success', 'Se ha eliminado exitosamente.');

        return $this->redirect(['index']);
    }

    /**
     * Finds the CausasCb model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_causas_cb Id Causas Cb
     * @return CausasCb the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_causas_cb)
    {
        if (($model = CausasCb::findOne(['id_causas_cb' => $id_causas_cb])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
