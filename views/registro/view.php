<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\Registro $model */

$this->title = $model->nro_accidente;
?>
<div class="registro-view">

    <br>
        <h3><?= Html::encode($this->title) ?></h3>
    <br>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id_registro',

            [   
                'attribute' => 'id_region',
                'label' => 'Region',
                'value' => function($model){
                    return   $model->region->descripcion;},
            ],

            [   
                'attribute' => 'id_estado',
                'label' => 'Estado',
                'value' => function($model){
                    return   $model->estado->descripcion;},
            ],

            [   
                'attribute' => 'id_naturaleza_accidente',
                'label' => 'Naturaleza del Accidente',
                'value' => function($model){
                    return   $model->naturalezaIncidente->descripcion;},
            ],

            'fecha_hora',
            'lugar',
            'nro_accidente',
            'cedula_supervisor_60min',
            'observaciones_60min',
            'autorizado_60m:boolean',
            'created_at',
            'updated_at',
            'id_estatus_proceso',
            //'id_region',
            'acciones_tomadas_60min',
            'cedula_reporta',
            'cedula_pers_accide',
            'cedula_validad_60min',
            'id_magnitud',
            'id_tipo_accidente',
            'id_tipo_trabajo',
            'id_peligro_agente',
            'id_sujeto_afectacion',
            'id_afecta_bienes_perso',
            'cedula_24horas',
            'acciones_tomadas_24horas',
            'observaciones_24horas',
            'recomendaciones_24horas',
            'autorizado_24horas:boolean',
            'cedula_valid_24horas',
            'descripcion_accidente_60min',
            'id_gerencia',
            'recomendaciones_60m',
            'anno',
            'correlativo',
            //'id_naturaleza_accidente',
            'ocurrencia_hecho_60m',
            'acciones_tomadas_24h',
            'observaciones_24h',
            'validado_por_24h',
            'id_requerimiento_trabajo_24h',
            'cumple_regla_oro:boolean',
            'id_afec_per_categoria',
        ],
    ]) ?>

    <!-- BOTON DE VOLVER-->
   <?= Html::button('Atrás', ['class' => 'my-custom-button', 'onclick' => 'location.href=\''.Url::toRoute(["index"]).'\'']) ?>

</div>
