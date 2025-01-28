<?php

namespace app\controllers;

use Yii;
use app\models\TipAccCategoria;
use app\models\TipacccategoriaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * TipacccategoriaController implements the CRUD actions for TipAccCategoria model.
 */
class TipacccategoriaController extends Controller
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
                        ['actions' => ['index'], 'allow' => true, 'roles' => ['tipacccategoria/index']],
                        ['actions' => ['create'], 'allow' => true, 'roles' => ['tipacccategoria/create']],
                        ['actions' => ['update'], 'allow' => true, 'roles' => ['tipacccategoria/update']],
                        ['actions' => ['delete'], 'allow' => true, 'roles' => ['tipacccategoria/delete']],
                        ['actions' => ['permisos'], 'allow' => true, 'roles' => ['tipacccategoria/permisos']],
                    ]
                ]
            ]
        );
    }

    /**
     * Lists all TipAccCategoria models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new TipacccategoriaSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TipAccCategoria model.
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

    /**
     * Creates a new TipAccCategoria model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new TipAccCategoria();

        if ($model->load(Yii::$app->request->post())) {
            // Set values
            $parent = TipAccCategoria::findOne($model->parent_id);
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
                        $child = new TipAccCategoria();
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
                        'title' => Yii::t('app', 'Create {modelClass}', ['modelClass' => Yii::t('app', 'TipAccCategoria')]) . ':',
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
     * Updates an existing TipAccCategoria model.
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
            $parent = TipAccCategoria::findOne($model->parent_id);
    
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
     * Deletes an existing TipAccCategoria model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
           //Eliminacion lógica
           $model = $this->findModel($id);
           $model->id_estatus = 2;
           $model->save(false);

        Yii::$app->session->setFlash('success', 'Se ha eliminado exitosamente.');
        return $this->redirect(['index']);
    }

    /**
     * Finds the TipAccCategoria model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return TipAccCategoria the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TipAccCategoria::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
