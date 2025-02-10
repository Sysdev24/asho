<?php

use app\models\PersonaNatural;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\PersonanaturalSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Persona Natural';

?>
<div class="persona-natural-index">

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
            //'id',
            
            //'cedula',
            [   
                'attribute' => 'cedula',
                'label' => 'Cedula',
                'contentOptions' => ['style' => 'width:15%; text-align: center; vertical-align: middle;'], // Cambia el tamaño de la columna
                'filterInputOptions' => [
                    'class' => 'form-control',
                    'placeholder' => 'Busqueda',
                ],
            ],

            //'nombre',
            [   
                'attribute' => 'nombre',
                'label' => 'Nombre',
                'contentOptions' => ['style' => 'width:15%; text-align: center; vertical-align: middle;'], // Cambia el tamaño de la columna
                'filterInputOptions' => [
                    'class' => 'form-control',
                    'placeholder' => 'Busqueda',
                ],
            ],

            //'apellido',

            [   
                'attribute' => 'apellido',
                'label' => 'Apellido',
                'contentOptions' => ['style' => 'width:15%; text-align: center; vertical-align: middle;'], // Cambia el tamaño de la columna
                'filterInputOptions' => [
                    'class' => 'form-control',
                    'placeholder' => 'Busqueda',
                ],
            ],

            //'created_at',
            //'updated_at',
            
            //'telefono',

            [   
                'attribute' => 'telefono',
                'label' => 'Telefono',
                'contentOptions' => ['style' => 'width:15%; text-align: center; vertical-align: middle;'], // Cambia el tamaño de la columna
                'filterInputOptions' => [
                    'class' => 'form-control',
                    'placeholder' => 'Busqueda',
                ],
            ],

            //'fecha_nac',
            //'id_registro',
            //'empresa',

            [   
                'attribute' => 'empresa',
                'label' => 'Empresa',
                'contentOptions' => ['style' => 'width:15%; text-align: center; vertical-align: middle;'], // Cambia el tamaño de la columna
                'filterInputOptions' => [
                    'class' => 'form-control',
                    'placeholder' => 'Busqueda',
                ],
            ],

            //'id_estatus',
             
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
                        return \Yii::$app->user->can('personanatural/index') ? $link : '';
                    },
                    // 'update' => function ($url, $model, $key) {
                    //     $url = ['update', 'id'=>$model->id];
                    //     $link = Html::a('<i class="fas fa-edit me-1"></i>', $url, [
                    //         'title' => Yii::t('yii', 'Update'),
                    //         'aria-label' => Yii::t('yii', 'Update'),
                    //         'data-pjax' => '0',
                    //         'class' => 'me-1',
                    //     ]);
                    //     return  \Yii::$app->user->can('personanatural/update') ? $link : '';
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
                    //     return \Yii::$app->user->can('personanatural/delete') ? $link : '';
                    // },
                ],
            ],  
        ],
    ]); ?>


</div>
