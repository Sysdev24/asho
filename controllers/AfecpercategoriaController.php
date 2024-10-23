<?php

namespace app\controllers;

use Yii;
use app\models\AfecPerCategoria;
use app\models\AfecpercategoriaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\components\Notify;


/**
 * AfecpercategoriaController implements the CRUD actions for AfecPerCategoria model.
 */
class AfecpercategoriaController extends Controller
{
    /**
     * @inheritDoc
     */
    //    public function behaviors()
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
    //                     ['actions' => ['index'], 'allow' => true, 'afecpercategoria' => ['afecpercategoria/index']],
    //                     ['actions' => ['create'], 'allow' => true, 'afecpercategoria' => ['afecpercategoria/create']],
    //                     ['actions' => ['update'], 'allow' => true, 'afecpercategoria' => ['afecpercategoria/update']],
    //                     ['actions' => ['delete'], 'allow' => true, 'afecpercategoria' => ['afecpercategoria/delete']],
    //                     ['actions' => ['permisos'], 'allow' => true, 'afecpercategoria' => ['afecpercategoria/permisos']],
    //                 ]
    //             ]
    //         ]
    //     );
    // }

    /**
     * Lists all AfecPerCategoria models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new AfecpercategoriaSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AfecPerCategoria model.
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
     * Creates a new AfecPerCategoria model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
{
    $model = new AfecPerCategoria();

    if ($model->load(Yii::$app->request->post())) {
        // Set values
        $parent = AfecPerCategoria::findOne($model->parent_id);
        $model->complete_name = $parent->complete_name . ' / ' . $model->name;
        $model->parent_path = $parent->parent_path . $model->id . '/';

        if($model->save()) {
            $model->parent_path = $parent->parent_path . $model->id . '/';
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);

        } else {
            if (YII_ENV_DEV) {
                Yii::$app->getSession()->setFlash('warning', [
                    [
                        'type' => 'toast',
                        'title' => Yii::t('app', 'Create {modelClass}', ['modelClass'=>Yii::t('app', 'AfecPerCategoria')]) . ':',
                        'message' => $this->listErrors($model->getErrors()),
                    ]
                ]);
            }
        }
    }

    return $this->render('create', [
        'model' => $model,
    ]);
}


    /**
     * Updates an existing AfecPerCategoria model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
{
    $model = $this->findModel($id);

    if ($model->load(Yii::$app->request->post())) {
        // Set values
        $parent = AfecPerCategoria::findOne($model->parent_id);
        $model->complete_name = $parent->complete_name . ' / ' . $model->name;
        $model->parent_path = $parent->parent_path . $model->id . '/';
        if($model->save()) {
            return $this->redirect(['index', 'id' => $model->id]);
        } else {
            if (YII_ENV_DEV) {
                Yii::$app->getSession()->setFlash('warning', [
                    [
                        'type' => 'toast',
                        'title' => Yii::t('app', 'Update {modelClass}', ['modelClass'=>Yii::t('app', 'AfecPerCategoria')]) . ':',
                        'message' => $this->listErrors($model->getErrors()),
                    ]
                ]);
            }
        }
    }

    return $this->render('update', [
        'model' => $model,
    ]);
}


    /**
     * Deletes an existing AfecPerCategoria model.
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
     * Finds the AfecPerCategoria model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return AfecPerCategoria the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AfecPerCategoria::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
