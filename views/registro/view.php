<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\Registro $model */

$this->title = $model->id_registro;
?>
<div class="registro-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id_registro',
            'id_estado',
            'fecha_hora',
            'lugar',
            'nro_accidente',
            'cedula_supervisor_60min',
            'observaciones_60min',
            'autorizado_60m:boolean',
            'created_at',
            'updated_at',
            'id_estatus_proceso',
            'id_region',
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
            'id_naturaliza_incidente',
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
