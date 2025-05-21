<?php

use app\models\Estados;
use app\models\Registro;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var app\models\RegistroSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Registros';
?>
<div class="registro-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Crear Registro', ['create'], ['class' => 'btn btn-success']) ?>
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
            [
                'class' => 'yii\grid\SerialColumn',
            'header' => 'Nº', //Para que no aparezca el # sino la letra que se requiera],
            'contentOptions' => ['style' => 'text-align: center; vertical-align: middle;'], // Cambia el tamaño de la columna
            ],

            //'id_registro',

            //'id_estado',

            //'fecha_hora',

                        
            [   
                'attribute' => 'cedula_reporta',
                'label' => 'Cédula Reporta',
                'filterInputOptions' => [
                    'class' => 'form-control',
                    'placeholder' => 'Busqueda',
                ]
            ],
            //'lugar',
            [   
                'attribute' => 'nro_accidente',
                'label' => 'Numero de accidente',
                'filterInputOptions' => [
                    'class' => 'form-control',
                    'placeholder' => 'Busqueda',
                ]
            ],

            [
                'attribute' => 'cedula_pers_accide',
                'value' => function($model) {
                    // Verifica si la cédula está seteada, si no, devuelve 'N/A'
                    // Aquí asumimos que un valor de 1 en la base de datos indica 'N/A'
                    if (is_null($model->cedula_pers_accide) || $model->cedula_pers_accide == 1) {
                        return 'N/A';
                    }
                    return $model->cedula_pers_accide;
                },
                'filterInputOptions' => ['class' => 'form-control', 'placeholder' => 'Busqueda'],
            ],

            [
                'attribute' => 'id_estado',
                'value' => array($searchModel, 'buscarEstados'),
                'filter' => Html::activeTextInput($searchModel, 'descripcion', [
                'class' => 'form-control',
                'placeholder' => 'Busqueda',
                ]),

            ],

            [   
                'attribute' => 'id_estatus_proceso',
                'label' => 'Estatus',
                'filterInputOptions' => [
                    'class' => 'form-control',
                    'placeholder' => 'Busqueda',
                ],
                'value' => function($model){
                    return   $model->estatusProceso->descripcion;},
            ],

            //'autorizado_60m:boolean',
            //'created_at',
            //'updated_at',
            //'id_region',
            //'cedula_validad_60min',
            //'id_magnitud',
            //'id_tipo_accidente',
            //'id_tipo_trabajo',
            //'id_peligro_agente',
            //'id_sujeto_afectacion',
            //'id_afecta_bienes_perso',
            //'cedula_24horas',
            //'acciones_tomadas_24horas',
            //'observaciones_24horas',
            //'recomendaciones_24horas',
            //'autorizado_24horas:boolean',
            //'cedula_valid_24horas',
            //'descripcion_accidente_60min',
            //'id_gerencia',
            //'recomendaciones_60m',
            //'anno',
            //'correlativo',
            //'id_naturaleza_accidente',
            //'ocurrencia_hecho_60m',
            //'acciones_tomadas_24h',
            //'observaciones_24h',
            //'validado_por_24h',
            //'id_requerimiento_trabajo_24h',
            //'cumple_regla_oro:boolean',
            //'id_afec_per_categoria',
            
            
            [
                'class' => ActionColumn::className(),
                //'hiddenFromExport' => true,
                'contentOptions' => ['class'=>'text-center align-middle', 'style'=>'min-width:110px;'],
                'template' => '{view}{update}',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        $url = ['view', 'id_registro'=>$model->id_registro];
                        $link = Html::a('<i class="fas fa-eye me-1"></i>', $url, [
                            'title' => Yii::t('yii', 'View'),
                            'aria-label' => Yii::t('yii', 'View'),
                            'data-pjax' => '0',
                            'class' => 'me-1',
                        ]);
                        return \Yii::$app->user->can('registro/index') ? $link : '';
                    },
                    'update' => function ($url, $model, $key) {
                        $url = ['update', 'id_registro'=>$model->id_registro];
                        $link = Html::a('<i class="fas fa-edit me-1"></i>', $url, [
                            'title' => Yii::t('yii', 'Update'),
                            'aria-label' => Yii::t('yii', 'Update'),
                            'data-pjax' => '0',
                            'class' => 'me-1',
                        ]);
                        return  \Yii::$app->user->can('registro/update') ? $link : '';
                    },
                ],
            ], 
            
            
            
            // [
            //     'class' => ActionColumn::className(),
            //     'urlCreator' => function ($action, Registro $model, $key, $index, $column) {
            //         return Url::toRoute([$action, 'id_registro' => $model->id_registro]);
            //     },
            //     'headerOptions' => ['class' => 'col-lg-1'], // Set header width to 10%
            //     'contentOptions' => ['class' => 'col-lg-1'], // Set content width to 10%
            // ],
        ],
    ]); ?>


</div>
