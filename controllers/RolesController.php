<?php

namespace app\controllers;

use Yii;
use app\models\RbacForm;
use app\models\RoleSearch;
use app\models\AsigRolesPermisosForm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;


/**
 * RolesController implements the CRUD actions for Roles model.
 */
class RolesController extends Controller
{
    /**
     * @inheritDoc
     */
//    public function behaviors()
//     {
//         return array_merge(
//             parent::behaviors(),
//             [
//                 'verbs' => [
//                     'class' => VerbFilter::class,
//                     'actions' => [
//                         'delete' => ['POST'],
//                     ],
//                 ],
//                 'access' => [
//                     'class' => AccessControl::class,
//                     'only' => [
//                         'index', 'create', 'update', 'delete', 'permisos',
//                     ], 
//                     'rules' => [
//                         ['actions' => ['index'], 'allow' => true, 'roles' => ['role/index']],
//                         ['actions' => ['create'], 'allow' => true, 'roles' => ['role/create']],
//                         ['actions' => ['update'], 'allow' => true, 'roles' => ['role/update']],
//                         ['actions' => ['delete'], 'allow' => true, 'roles' => ['role/delete']],
//                         ['actions' => ['permisos'], 'allow' => true, 'roles' => ['role/permisos']],
//                     ]
//                 ]
//             ]
//         );
//     }

    /**
     * Lists all Roles models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new RoleSearch();
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
        $model->scenario = RbacForm::SCENARIO_CREATE;
        $model->isNewRecord = true;
        $errorMessage = '';
        

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {

                try {
                    $auth = Yii::$app->authManager;
                    $role = $auth->createRole($model->name);
                    $role->description = $model->description;
                    if($auth->add($role)) { 
                    Yii::$app->session->setFlash('success', 'Se ha creado exitosamente.');
                    return $this->redirect(['index', 'id' => $model->name]);
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
        $errorMessage = "";

        if ($this->request->isPost && $model->load($this->request->post())) {

            try {
                $auth = Yii::$app->authManager;
                $role = $auth->getRole($id);
                $role->name = $model->name;
                $role->description = $model->description;

                if ($auth->update($id, $role)) {
                    Yii::$app->session->setFlash('success', 'Actualizacion exitosa.');
                    return $this->redirect(['index', 'id' => $model->name]);
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
     * Updates an existing Roles model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_roles Id Roles
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionPermisos($id)
    {
        $role = $this->findModel($id);
        $auth = Yii::$app->authManager;
        $model = new AsigRolesPermisosForm();
        $model->name = $id;
        
        $model->setRoles($id);
        $model->setPermisos($id);

        $errorMessage = '';

        if ($this->request->isPost && $model->load($this->request->post())) {

            if (!$errorMessage = $model->save()) {
                return $this->redirect(['view', 'id' => $model->name]);
            } 
        }

        return $this->render('permisos', [
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
        $role = $auth->getRole($id);
        
        $auth->remove($role);
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
    	if ($auth->getRole($id) !== null) {
    	    $model->setAttributes((array)$auth->getRole($id));
    		return $model;
    	} else {
    		throw new NotFoundHttpException(Yii::t('yii', 'The requested page does not exist.'));
    	}
    }
}
