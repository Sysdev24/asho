<?php

use app\models\ReglaOro;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use app\models\Estatus;


/** @var yii\web\View $this */
/** @var app\models\ReglaoroSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Regla de Oro';
?>
<div class="regla-oro-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Crear Regla de Oro', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pager' => [
            'options' => ['class'=> 'pagination'],
            'firstPageCssClass' => 'page-item',
            'lastPageCssClass' => 'page-item', 
            'nextPageCssClass' => 'page-item',
            'prevPageCssClass' => 'page-item',
            'pageCssClass' => 'page-item',
            'disabledPageCssClass' => 'disabled d-none',
            'linkOptions' => ['style' => 'text-decoration: none;', 'class' => 'page-link'],
        ],
        'columns' => [
           
            ['class' => 'yii\grid\SerialColumn',
            'header' => 'Nº', //Para que no aparezca el # sino la letra que se requiera],
            'contentOptions' => ['style' => 'text-align: center; vertical-align: middle;'], // Cambia el tamaño de la columna
            ], 

            //'id_regla_oro',
            //'descripcion',
            [   
                'attribute' => 'descripcion',
                'label' => 'Descripcion',
                'filterInputOptions' => [
                    'class' => 'form-control',
                    'placeholder' => 'Busqueda',
                ],
            ],
            //'id_estatus',


           //Esto es Para que muestre el estatus en vez del id almacenado en la tabla regiones
           [   
            'attribute' => 'id_estatus',
            'value' => array($searchModel, 'buscarEstatus'),
            'filter' => 
            Html::activeDropDownList($searchModel, 'id_estatus',
            ArrayHelper::map(Estatus::find()->all(), 'id_estatus', 'descripcion'),
            ['prompt'=> 'Busqueda', 'class' => 'form-control']),
            'headerOptions' => ['class' => 'col-lg-03 text-center'],
            'contentOptions' => ['class' => 'col-lg-03 text-center'],

        ],

            //'created_at',
            //'updated_at',
           
           
            [
                'class' => ActionColumn::className(),
                //'hiddenFromExport' => true,
                'contentOptions' => ['class'=>'text-center align-middle', 'style'=>'min-width:110px;'],
                'template' => '{view}{update}{delete}',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        $url = ['view', 'id_regla_oro'=>$model->id_regla_oro];
                        $link = Html::a('<i class="fas fa-eye me-1"></i>', $url, [
                            'title' => Yii::t('yii', 'View'),
                            'aria-label' => Yii::t('yii', 'View'),
                            'data-pjax' => '0',
                            'class' => 'me-1',
                        ]);
                        return \Yii::$app->user->can('reglaoro/index') ? $link : '';
                    },
                    'update' => function ($url, $model, $key) {
                        $url = ['update', 'id_regla_oro'=>$model->id_regla_oro];
                        $link = Html::a('<i class="fas fa-edit me-1"></i>', $url, [
                            'title' => Yii::t('yii', 'Update'),
                            'aria-label' => Yii::t('yii', 'Update'),
                            'data-pjax' => '0',
                            'class' => 'me-1',
                        ]);
                        return  \Yii::$app->user->can('reglaoro/update') ? $link : '';
                    },
                    'delete' => function ($url, $model, $key) {
                        $url = ['delete', 'id_regla_oro'=>$model->id_regla_oro];
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
                        return \Yii::$app->user->can('reglaoro/delete') ? $link : '';
                    },
                ],
            ],
           
           
            // [
            //     'class' => ActionColumn::className(),
            //     'urlCreator' => function ($action, ReglaOro $model, $key, $index, $column) {
            //         return Url::toRoute([$action, 'id_regla_oro' => $model->id_regla_oro]);
            //      }
            // ],
        ],
    ]); ?>


</div>
