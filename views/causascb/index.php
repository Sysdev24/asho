<?php

use app\models\CausasCb;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\CausascbSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Causas Cbs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="causas-cb-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <!-- <p>
        <?= Html::a('Create Causas Cb', ['create'], ['class' => 'btn btn-success']) ?>
    </p> -->

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_causas_cb',
            'id_sub2_fac',
            'id_sub_fac',
            'id_cau_fac_bas_raiz',
            'id_cau_bas_raiz',
            //'descripcion',
            //'created_at',
            //'updated_at',
            //'id_estatus',

            [
                'class' => ActionColumn::className(),
                //'hiddenFromExport' => true,
                'contentOptions' => ['class'=>'text-center align-middle', 'style'=>'min-width:110px;'],
                'template' => '{view}{update}{delete}',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        $url = ['view', 'id_causas_cb'=>$model->id_causas_cb];
                        $link = Html::a('<i class="fas fa-eye me-1"></i>', $url, [
                            'title' => Yii::t('yii', 'View'),
                            'aria-label' => Yii::t('yii', 'View'),
                            'data-pjax' => '0',
                            'class' => 'me-1',
                        ]);
                        return \Yii::$app->user->can('causascb/index') ? $link : '';
                    },
                    'update' => function ($url, $model, $key) {
                        $url = ['update', 'id_causas_cb'=>$model->id_causas_cb];
                        $link = Html::a('<i class="fas fa-edit me-1"></i>', $url, [
                            'title' => Yii::t('yii', 'Update'),
                            'aria-label' => Yii::t('yii', 'Update'),
                            'data-pjax' => '0',
                            'class' => 'me-1',
                        ]);
                        return  \Yii::$app->user->can('causascb/update') ? $link : '';
                    },
                    'delete' => function ($url, $model, $key) {
                        $url = ['delete', 'id_causas_cb'=>$model->id_causas_cb];
                        $link = Html::a('<i class="fas fa-trash-alt me-2"></i>', $url, [
                            'title' => Yii::t('yii', 'Delete'),
                            'aria-label' => Yii::t('yii', 'Delete'),
                            'data-pjax' => '0',
                            'class' => 'mx-0',
                            'data' => [
                                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                                'method' => 'post',
                            ],
                        ]);
                        return \Yii::$app->user->can('causascb/delete') ? $link : '';
                    },
                ],
            ],


            // [
            //     'class' => ActionColumn::className(),
            //     'urlCreator' => function ($action, CausasCb $model, $key, $index, $column) {
            //         return Url::toRoute([$action, 'id_causas_cb' => $model->id_causas_cb]);
            //      }
            // ],
        ],
    ]); ?>


</div>
