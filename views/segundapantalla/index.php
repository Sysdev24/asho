<?php

use app\models\SegundaPantalla;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\SegundapantallaSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Pantalla 24 horas';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="segunda-pantalla-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Crear Pantalla 24 horas', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
           
            [   
                'attribute' => 'nro_accidente',
                'label' => 'N° Accidente',
                'contentOptions' => ['style' => 'width:16%; text-align: center; vertical-align: middle;'], // Cambia el tamaño de la columna
                'filterInputOptions' => [
                    'class' => 'form-control',
                    'placeholder' => 'Busqueda',
                ],
            ],

            [   
                'attribute' => 'id_registro',
                'label' => 'Id de registro',
                'contentOptions' => ['style' => 'width:12%; text-align: center; vertical-align: middle;'], // Cambia el tamaño de la columna
                'filterInputOptions' => [
                    'class' => 'form-control',
                    'placeholder' => 'Busqueda',
                ],
            ],

            [
                'attribute' => 'id_magnitud',
                'label' => 'Magnitud',
                'value' => function ($model) {
                    return $model->magnitud ? $model->magnitud->descripcion : 'N/A';
                },
                'contentOptions' => ['style' => 'width:25%; text-align: center; vertical-align: middle;'], // Cambia el tamaño de la columna
                'filterInputOptions' => [
                    'class' => 'form-control',
                    'placeholder' => 'Busqueda',
                ],
            ],
            
            
            [
                'attribute' => 'id_estado',
                'value' => array($searchModel, 'buscarEstados'),
                'contentOptions' => ['style' => 'width:16%; text-align: center; vertical-align: middle;'], // Cambia el tamaño de la columna
                'filter' => Html::activeTextInput($searchModel, 'descripcion', [
                'class' => 'form-control',
                'placeholder' => 'Busqueda',
                ]),

            ],


            //'fecha_hora',
            //'lugar',
            //'cedula_supervisor_60min',
            //'observaciones_60min',
            //'autorizado_60m:boolean',
            //'created_at',
            //'updated_at',
            //'id_estatus_proceso',
            //'id_region',
            //'acciones_tomadas_60min',
            'cedula_reporta',
            //'cedula_pers_accide',
            //'cedula_validad_60min',
            //'id_tipo_accidente',
            //'id_tipo_trabajo',
            //'id_peligro_agente',
            //'id_sujeto_afectacion',
            //'cedula_24horas',
            //'acciones_tomadas_24horas',
            //'observaciones_24horas',
            //'recomendaciones_24horas',
            //'autorizado_24horas:boolean',
            //'cedula_valid_24horas',
            //'descripcion_accidente_60min',
            //'id_gerencia',
            //'correlativo',
            //'id_naturaleza_accidente',
            //'ocurrencia_hecho_60m',
            //'acciones_tomadas_24h',
            //'observaciones_24h',
            //'validado_por_24h',
            //'id_requerimiento_trabajo_24h',
            //'id_afec_per_categoria',
            //'id_exposicion_con_cat',
            //'orden_persona',
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
                        return \Yii::$app->user->can('segundapantalla/index') ? $link : '';
                    },
                    'update' => function ($url, $model, $key) {
                        $url = ['update', 'id_registro'=>$model->id_registro];
                        $link = Html::a('<i class="fas fa-edit me-1"></i>', $url, [
                            'title' => Yii::t('yii', 'Update'),
                            'aria-label' => Yii::t('yii', 'Update'),
                            'data-pjax' => '0',
                            'class' => 'me-1',
                        ]);
                        return  \Yii::$app->user->can('segundapantalla/update') ? $link : '';
                    },
                ],
            ], 
        ],
    ]); ?>


</div>
