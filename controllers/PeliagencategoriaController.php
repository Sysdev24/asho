<?php

namespace app\controllers;

use Yii;
use app\models\PeliAgenCategoria;
use app\models\PeliagencategoriaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Response;

/**
 * PeliagencategoriaController implements the CRUD actions for PeliAgenCategoria model.
 */
class PeliagencategoriaController extends Controller
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
                        ['actions' => ['index'], 'allow' => true, 'roles' => ['peliagencategoria/index']],
                        ['actions' => ['create'], 'allow' => true, 'roles' => ['peliagencategoria/create']],
                        ['actions' => ['update'], 'allow' => true, 'roles' => ['peliagencategoria/update']],
                        ['actions' => ['delete'], 'allow' => true, 'roles' => ['peliagencategoria/delete']],
                        ['actions' => ['permisos'], 'allow' => true, 'roles' => ['peliagencategoria/permisos']],
                    ]
                ]
            ]
        );
    }

    /**
     * Lists all PeliAgenCategoria models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new PeliagencategoriaSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PeliAgenCategoria model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionGetItems($parent_id)
    {
        $items = PeliAgenCategoria::find()->where(['parent_id' => $parent_id])->all();
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['items' => $items];
    }

    /**
     * Creates a new PeliAgenCategoria model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new PeliAgenCategoria();

        if ($model->load(Yii::$app->request->post())) {
            // Set values
            $parent = PeliAgenCategoria::findOne($model->parent_id);
            if ($parent) {
                $model->complete_name = $parent->complete_name . ' / ' . $model->name;
                $model->parent_path = trim($parent->parent_path, '/') . '/' . $model->id . '/';
            } else {
                $model->complete_name = $model->name;
                $model->parent_path = '/' . $model->id . '/';
            }

            if ($model->save()) {
                if (!empty($model->child_ids)) {
                    foreach ($model->child_ids as $childId) {
                        $child = new PeliAgenCategoria();
                        $child->parent_id = $model->id;
                        $child->id = $childId;
                        $child->save();
                    }
                }

                Yii::$app->getSession()->setFlash('success', 'Se ha creado exitosamente.');
                return $this->redirect(['index', 'id' => $model->id]);
            } else {
                Yii::$app->getSession()->setFlash('error', 'Ha habido un error.');

                if (YII_ENV_DEV) {
                    Yii::$app->getSession()->setFlash('warning', [
                        'type' => 'toast',
                        'title' => Yii::t('app', 'Create {modelClass}', ['modelClass' => Yii::t('app', 'PeliAgenCategoria')]) . ':',
                        'message' => $this->listErrors($model->getErrors()),
                    ]);
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
    

    /**
     * Updates an existing PeliAgenCategoria model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
    
        if ($model->load(Yii::$app->request->post())) {
            // Se busca la categoría padre
            $parent = PeliAgenCategoria::findOne($model->parent_id);
    
            // Verifica si se encontró la categoría padre
            if ($parent) {
                // Si se encontró, actualiza los campos del modelo
                $model->complete_name = $parent->complete_name . ' / ' . $model->name;
                $model->parent_path = $parent->parent_path . $model->id . '/';
            } 
    
            if ($model->save()) {
                // Redireccionamos a la vista de índice y mostramos un mensaje de éxito
                return $this->redirect(['index', 'id' => $model->id]);
            } else {
                // Si hay errores de validación, mostramos los errores
                // ... (tu código existente para mostrar errores)
            }
        }
    
        return $this->render('update', [
            'model' => $model,
        ]);
    }


    /**
     * Deletes an existing PeliAgenCategoria model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', 'Se ha eliminado exitosamente.');
        return $this->redirect(['index']);
    }

    /**
     * Finds the PeliAgenCategoria model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return PeliAgenCategoria the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PeliAgenCategoria::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
