<?php

namespace app\controllers;

use Yii;
use app\models\TipoContacto;
use app\models\TipocontactoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;


/**
 * TipocontactoController implements the CRUD actions for TipoContacto model.
 */
class TipocontactoController extends Controller
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
    //                     ['actions' => ['index'], 'allow' => true, 'roles' => ['tipocontacto/index']],
    //                     ['actions' => ['create'], 'allow' => true, 'roles' => ['tipocontacto/create']],
    //                     ['actions' => ['update'], 'allow' => true, 'roles' => ['tipocontacto/update']],
    //                     ['actions' => ['delete'], 'allow' => true, 'roles' => ['tipocontacto/delete']],
    //                     ['actions' => ['permisos'], 'allow' => true, 'roles' => ['tipocontacto/permisos']],
    //                 ]
    //             ]
    //         ]
    //     );
    // }

    /**
     * Lists all TipoContacto models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new TipocontactoSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TipoContacto model.
     * @param int $id_tipo_contacto Id Tipo Contacto
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_tipo_contacto)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_tipo_contacto),
        ]);
    }

    /**
     * Creates a new TipoContacto model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new TipoContacto();
        $model->scenario = TipoContacto::SCENARIO_CREATE;


        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {

                Yii::$app->session->setFlash('success', 'Se ha creado exitosamente.');

                return $this->redirect(['view', 'id_tipo_contacto' => $model->id_tipo_contacto]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TipoContacto model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_tipo_contacto Id Tipo Contacto
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_tipo_contacto)
    {
        $model = $this->findModel($id_tipo_contacto);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {

            Yii::$app->session->setFlash('success', 'Actualizacion exitosa.');

            return $this->redirect(['view', 'id_tipo_contacto' => $model->id_tipo_contacto]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing TipoContacto model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_tipo_contacto Id Tipo Contacto
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_estado)
    {
           //Eliminacion lógica
           $model = $this->findModel($id_estado);
           $model->id_estatus = 2;
           $model->save(false);
        
        Yii::$app->session->setFlash('success', 'Se ha eliminado exitosamente.');

        return $this->redirect(['index']);
    }

    /**
     * Finds the TipoContacto model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_tipo_contacto Id Tipo Contacto
     * @return TipoContacto the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_tipo_contacto)
    {
        if (($model = TipoContacto::findOne(['id_tipo_contacto' => $id_tipo_contacto])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
