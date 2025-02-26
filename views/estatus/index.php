<?php

use app\models\Estatus;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;


/** @var yii\web\View $this */
/** @var app\models\EstatusSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Estatus';
?>
<div class="estatus-index">

    <h1><?= Html::encode($this->title) ?></h1>

    

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

            //'id_estatus',


            // //Esto es Para que muestre el estatus en vez del id almacenado en la tabla regiones
            // [   
            //     'attribute' => 'id_estatus',
            //     'value' => array($searchModel, 'buscarEstatus'),
            //     'filter' => 
            //     Html::activeDropDownList($searchModel, 'id_estatus',
            //     ArrayHelper::map(Estatus::find()->all(), 'id_estatus', 'descripcion'),
            //     ['prompt'=> 'Busqueda', 'class' => 'form-control']),
            //     'headerOptions' => ['class' => 'col-lg-03 text-center'],
            //     'contentOptions' => ['class' => 'col-lg-03 text-center'],

            // ],


           // 'descripcion',
            [   
                'attribute' => 'descripcion',
                'label' => 'Descripcion',
                'filterInputOptions' => [
                    'class' => 'form-control',
                    'placeholder' => 'Busqueda',
                ]
            ],
            //'siglas',
            [   
                'attribute' => 'siglas',
                'label' => 'Siglas',
                'filterInputOptions' => [
                    'class' => 'form-control',
                    'placeholder' => 'Busqueda',
                ]
            ],
            //'created_at',
            //'updated_at',
         
            // [
            //     'class' => ActionColumn::className(),
            //     //'hiddenFromExport' => true,
            //     'contentOptions' => ['class'=>'text-center align-middle', 'style'=>'min-width:110px;'],
            //     'template' => '{update}{delete}',
            //     'buttons' => [
            //         'update' => function ($url, $model, $key) {
            //             $url = ['update', 'id_estatus'=>$model->id_estatus];
            //             $link = Html::a('<i class="fas fa-edit me-1"></i>', $url, [
            //                 'title' => Yii::t('yii', 'Update'),
            //                 'aria-label' => Yii::t('yii', 'Update'),
            //                 'data-pjax' => '0',
            //                 'class' => 'me-1',
            //             ]);
            //             return  \Yii::$app->user->can('estatus/update') ? $link : '';
            //         },
            //         'delete' => function ($url, $model, $key) {
            //             $url = ['delete', 'id_estatus'=>$model->id_estatus];
            //             $link = Html::a('<i class="fa-solid fa-toggle-off"></i>', $url, [
            //                 'title' => Yii::t('yii', 'Desactivar'),
            //                 'aria-label' => Yii::t('yii', 'Delete'),
            //                 'data-pjax' => '0',
            //                 'class' => 'mx-0',
            //                 'data' => [
            //                     'confirm' => Yii::t('app', 'Está seguro que desea eliminar este ícono?'),
            //                     'method' => 'post',
            //                 ],
            //             ]);
            //             return \Yii::$app->user->can('estatus/delete') ? $link : '';
            //         },
            //     ],
            // ],
         
         
            // [
            //     'class' => ActionColumn::className(),
            //     'urlCreator' => function ($action, Estatus $model, $key, $index, $column) {
            //         return Url::toRoute([$action, 'id_estatus' => $model->id_estatus]);
            //      }
            // ],
        ],
    ]); ?>


</div>
