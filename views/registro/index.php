<?php

use app\models\Registro;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\RegistroSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Registros';
$this->params['breadcrumbs'][] = $this->title;
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
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id_registro',
            //'id_estado',
            [   
                'attribute' => 'id_estado',
                'label' => 'Estado',
                'filterInputOptions' => [
                    'class' => 'form-control',
                    'placeholder' => 'Busqueda',
                ]
            ],

            //'fecha_hora',
            [   
                'attribute' => 'fecha_hora',
                'label' => 'Fecha y hora',
                'filterInputOptions' => [
                    'class' => 'form-control',
                    'placeholder' => 'Busqueda',
                ]
            ],

            //'lugar',
            [   
                'attribute' => 'lugar',
                'label' => 'Lugar',
                'filterInputOptions' => [
                    'class' => 'form-control',
                    'placeholder' => 'Busqueda',
                ]
            ],

            //'nro_accidente',
            [   
                'attribute' => 'nro_accidente',
                'label' => 'Nro Accidente',
                'filterInputOptions' => [
                    'class' => 'form-control',
                    'placeholder' => 'Busqueda',
                ]
            ],

            //'cedula_supervisor_60min',
            //'observaciones_60min',
            //'autorizado_60m:boolean',
            //'created_at',
            //'updated_at',
            //'id_estatus_proceso',
            //'id_region',
            //'acciones_tomadas_60min',
            //'cedula_reporta',
            //'cedula_pers_accide',
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
            //'id_naturaliza_incidente',
            //'ocurrencia_hecho_60m',
            //'acciones_tomadas_24h',
            //'observaciones_24h',
            //'validado_por_24h',
            //'id_requerimiento_trabajo_24h',
            //'cumple_regla_oro:boolean',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Registro $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id_registro' => $model->id_registro]);
                 }
            ],
        ],
    ]); ?>


</div>
