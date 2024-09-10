<?php


namespace app\controllers;

use Yii;
use app\models\RbacForm;
use app\models\Roles;
use app\models\RoleSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\PermissionsSearch;
use yii\helpers\Html;
use app\widgets\Notify;


/**
 * RolesController implements the CRUD actions for Roles model.
 */
class RolesController extends Controller
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
        $searchModel = new RoleSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionPermissions()
    {
        echo "aqui";
        exit;

        $searchModel = new PermissionsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        return $this->render('permissions', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionPrueba()
    {
        echo "aqui";
        exit;
    }

    /***************
	 * Item Permissions
	 ***************/

	/**
	 *
	 * @return Ambigous <string, string>
	 */
    public function actionCreatePermission()
    {
        $model = new RbacForm();
        $model->isNewRecord = true;

    	if ($model->load(Yii::$app->request->post())) {
    		$auth = Yii::$app->authManager;
            $permission = $auth->createPermission($model->name);
            $permission->description = $model->description;

			try {
				if ($auth->add($permission)) {
	    		    // MESSAGE
					Yii::$app->getSession()->setFlash('success', [
						[
							'type' => 'toast',
							'title' => Html::tag('h5', Yii::t('app', 'Create {modelClass}', ['modelClass'=>Yii::t('app','Permission')]) . ':'),
							'message' => Yii::t('app', 'The record has been saved successfully.'),
						]
					]);
					Notify::create([
						'title' => Yii::t('app', 'Create {modelClass}', ['modelClass'=>Yii::t('app', 'Permission')]) . '<i class="fa fa-circle-plus text-success ms-2"></i>', 
						'message' => Yii::t('app', 'The record {name} has been saved successfully.', ['name' => $model->name]), 
						'image_type' => Notify::TYPE_ICON, 
						'image' => 'fa fa-tag bg-dark text-primary'
					]);
	    			return $this->redirect(['permissions']);
	    		}
			} catch (\Exception $e) {
				// MESSAGE
				Yii::$app->getSession()->setFlash('error', [
					[
						'type' => 'toast',
						'title' => Html::tag('h5', Yii::t('app', 'Create {modelClass}', ['modelClass'=>Yii::t('app','Permission')]) . ':'),
						'message' => Yii::t('app', 'The record could not be saved.') . ' ' . Yii::t('app', 'Please, check that the data entered is unique.'),
					]
				]);
			}
    	}

    	return $this->render('create-permission', [
    		'model' => $model,
    	]);
    }

    public function actionUpdatePermission($id)
    {
        $id = Yii::$app->getSecurity()->validateData($id, Yii::$app->params['keyCrypt']);
        $model = $this->findModelPermission($id);

        if ($model->load(Yii::$app->request->post())) {
            $auth = Yii::$app->authManager;
            $permission = $auth->getPermission($id);
            $permission->name = $model->name;
            $permission->description = $model->description;

			try {
				if ($auth->update($id, $permission)) {
	                // MESSAGE
					Yii::$app->getSession()->setFlash('success', [
						[
							'type' => 'toast',
							'title' => Html::tag('h5', Yii::t('app', 'Update {modelClass}', ['modelClass'=>Yii::t('app','Permission')]) . ':'),
							'message' => Yii::t('app', 'The record has been updated successfully.'),
						]
					]);
					Notify::create([
						'title' => Yii::t('app', 'Update {modelClass}', ['modelClass'=>Yii::t('app', 'Permission')]) . '<i class="fa fa-circle-plus text-success ms-2"></i>', 
						'message' => Yii::t('app', 'The record {name} has been saved successfully.', ['name' => $model->name]), 
						'image_type' => Notify::TYPE_ICON, 
						'image' => 'fa fa-tag bg-dark text-primary'
					]);
	                return $this->redirect(['permissions']);
	            }
			} catch (\Exception $e) {
				// MESSAGE
				Yii::$app->getSession()->setFlash('error', [
					[
						'type' => 'toast',
						'title' => Html::tag('h5', Yii::t('app', 'Update {modelClass}', ['modelClass'=>Yii::t('app','Permission')]) . ':'),
						'message' => Yii::t('app', 'The record could not be updated.') . ' ' . Yii::t('app', 'Please, check that the data entered is unique.'),
					]
				]);
			}
        }
        return $this->render('update-permission', [
            'model' => $model,
        ]);
    }

    public function actionDeletePermission($id)
    {
        $id = Yii::$app->getSecurity()->validateData($id, Yii::$app->params['keyCrypt']);
        $auth = Yii::$app->authManager;
        $permission = $auth->getPermission($id);
        if ($auth->remove($permission)) {
            // MESSAGE
			Yii::$app->getSession()->setFlash('success', [
				[
					'type' => 'toast',
					'title' => Html::tag('h5', Yii::t('app', 'Delete {modelClass}', ['modelClass'=>Yii::t('app','Permission')]) . ':'),
					'message' => Yii::t('app', 'The record has been deleted successfully.'),
				]
			]);
			Notify::create([
				'title' => Yii::t('app', 'Delete {modelClass}', ['modelClass'=>Yii::t('app', 'Permission')]) . '<i class="fa fa-circle-plus text-success ms-2"></i>', 
				'message' => 'The record "' . $permission->name . '" has been deleted successfully.', 
				'image_type' => Notify::TYPE_ICON, 
				'image' => 'fa fa-tag bg-dark text-primary'
			]);
        }
        return $this->redirect(['permissions']);
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
};