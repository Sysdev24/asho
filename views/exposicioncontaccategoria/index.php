<?php

use app\models\ExposicionContacCategoria;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use app\models\Estatus;

/** @var yii\web\View $this */
/** @var app\models\ExposicioncontaccategoriaSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Exposicion o Contacto';

?>
<div class="exposicion-contac-categoria-index">

    <h1><?= Html::encode($this->title) ?></h1>
    
       <!-- <p>
       <?= Html::a('Crear Exposicion o Contacto ', ['create'], ['class' => 'btn btn-success']) ?>
    </p> -->


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

            [   
                'attribute' => 'name',
                'label' => 'Nombre',
                'contentOptions' => ['style' => 'width:40%; text-align: center; vertical-align: middle;'], // Cambia el tamaño de la columna
                'filterInputOptions' => [
                    'class' => 'form-control',
                    'placeholder' => 'Busqueda',
                ],                    
            ],

            [   
                'attribute' => 'codigo',
                'label' => 'Código',
                'contentOptions' => ['style' => 'width:15%; text-align: center; vertical-align: middle;'], // Cambia el tamaño de la columna
                'filterInputOptions' => [
                    'class' => 'form-control',
                    'placeholder' => 'Busqueda',
                ],                    
            ],
            
            //Esto es Para que muestre el estatus en vez del id almacenado en la tabla regiones
            [   
                'attribute' => 'id_estatus',
                'label' => 'Estatus',
                'value' => array($searchModel, 'buscarEstatus'),
                'filter' => 
                Html::activeDropDownList($searchModel, 'id_estatus',
                ArrayHelper::map(Estatus::find()
                ->where(['in', 'descripcion', ['ACTIVO', 'INACTIVO']])
                ->all(),
                'id_estatus',
                'descripcion'),
                ['prompt'=> 'Busqueda', 'class' => 'form-control']),
                'headerOptions' => ['class' => 'col-lg-03 text-center'],
                'contentOptions' => ['class' => 'col-lg-03 text-center'],
            ],
            
            [
                'class' => ActionColumn::className(),
                //'hiddenFromExport' => true,
                'contentOptions' => ['class'=>'text-center align-middle', 'style'=>'min-width:110px;'],
                'template' => '{view}',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        $url = ['view', 'id'=>$model->id];
                        $link = Html::a('<i class="fas fa-eye me-1"></i>', $url, [
                            'title' => Yii::t('yii', 'View'),
                            'aria-label' => Yii::t('yii', 'View'),
                            'data-pjax' => '0',
                            'class' => 'me-1',
                        ]);
                        return \Yii::$app->user->can('exposicioncontaccategoria/index') ? $link : '';
                    },
                    // 'update' => function ($url, $model, $key) {
                    //     $url = ['update', 'id'=>$model->id];
                    //     $link = Html::a('<i class="fas fa-edit me-1"></i>', $url, [
                    //         'title' => Yii::t('yii', 'Update'),
                    //         'aria-label' => Yii::t('yii', 'Update'),
                    //         'data-pjax' => '0',
                    //         'class' => 'me-1',
                    //     ]);
                    //     return  \Yii::$app->user->can('exposicioncontaccategoria/update') ? $link : '';
                    // },
                    // 'delete' => function ($url, $model, $key) {
                    //     $url = ['delete', 'id'=>$model->id];
                    //     $link = Html::a('<i class="fa-solid fa-toggle-off"></i>', $url, [
                    //         'title' => Yii::t('yii', 'Desactivar'),
                    //         'aria-label' => Yii::t('yii', 'Delete'),
                    //         'data-pjax' => '0',
                    //         'class' => 'mx-0',
                    //         'data' => [
                    //             'confirm' => Yii::t('app', 'Está seguro que desea eliminar este ícono?'),
                    //             'method' => 'post',
                    //         ],
                    //     ]);
                    //     return \Yii::$app->user->can('exposicioncontaccategoria/delete') ? $link : '';
                    // },
                ],
            ],
        ],

    ]); ?>


</div>
