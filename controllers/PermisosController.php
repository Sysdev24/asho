<?php

namespace app\controllers;

use Yii;
use app\models\RbacForm;
use app\models\PermissionsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


/**
 * RolesController implements the CRUD actions for Roles model.
 */
class PermisosController extends Controller
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
     * Lists all Roles models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new PermissionsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Roles model.
     * @param int $id_roles Id Roles
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Roles model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new RbacForm();
        $model->isNewRecord = true;
        $errorMessage = '';

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {

                try {
                    $auth = Yii::$app->authManager;
                    $permiso = $auth->createPermission($model->name);
                    $permiso->description = $model->description;
                    if($auth->add($permiso)) { 
                    Yii::$app->session->setFlash('success', 'Se ha creado exitosamente.');
                    return $this->redirect(['view', 'id' => $model->name]);
                    } else {
                        $errorMessage = 'Error al guardar registro.';
                    }
                } catch (\Throwable $th) {
                    $errorMessage = 'Error al guardar registro.';
                }
            }
        } 

        return $this->render('create', [
            'model' => $model,
            'errorMessage' => $errorMessage,
        ]);
    }

    /**
     * Updates an existing Roles model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_roles Id Roles
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $errorMessage = '';

        if ($this->request->isPost && $model->load($this->request->post())) {

            try {
                $auth = Yii::$app->authManager;
                $permiso = $auth->getPermission($id);
                $permiso->name = $model->name;
                $permiso->description = $model->description;

                if ($auth->update($id, $permiso)) {
                    Yii::$app->session->setFlash('success', 'Actualizacion exitosa.');
                    return $this->redirect(['view', 'id' => $model->name]);
                } else {
                    $errorMessage = 'Error al guardar registro.';
                }
            } catch (\Throwable $th) {
                $errorMessage = 'Error al guardar registro.';
            }
        }

        return $this->render('update', [
            'model' => $model,
            'errorMessage' => $errorMessage,
        ]);
    }

    /**
     * Deletes an existing Roles model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_roles Id Roles
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $auth = Yii::$app->authManager;
        $permiso = $auth->getPermission($id);

        $auth->remove($permiso);
        Yii::$app->session->setFlash('success', 'Se ha eliminado exitosamente.');
        return $this->redirect(['index']);
    }

    /**
     * Finds the Roles model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_roles Id Roles
     * @return Roles the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $model = new RbacForm();
        $auth = Yii::$app->authManager;
    	if ($auth->getPermission($id) !== null) {
    	    $model->setAttributes((array)$auth->getPermission($id));
    		return $model;
    	} else {
    		throw new NotFoundHttpException(Yii::t('yii', 'The requested page does not exist.'));
    	}
    }
}
