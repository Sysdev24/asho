<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\SegundaPantalla $model */

$this->title = $model->id_registro;
//$this->params['breadcrumbs'][] = ['label' => 'Segunda Pantallas', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="segunda-pantalla-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <br>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
             'id_registro',
             'id_estado',
             'fecha_hora',
             'lugar',
             'nro_accidente',
             'cedula_supervisor_60min',
            // 'observaciones_60min',
            // 'autorizado_60m:boolean',
            // 'created_at',
            // 'updated_at',
            // 'id_estatus_proceso',
            // 'id_region',
            // 'acciones_tomadas_60min',
            // 'cedula_reporta',
            // 'cedula_pers_accide',
            // 'cedula_validad_60min',
            // 'id_magnitud',
            // 'id_tipo_accidente',
            // 'id_tipo_trabajo',
            // 'id_peligro_agente',
            // 'id_sujeto_afectacion',
            // 'cedula_24horas',
            // 'acciones_tomadas_24horas',
            // 'observaciones_24horas',
            // 'recomendaciones_24horas',
            // 'autorizado_24horas:boolean',
            // 'cedula_valid_24horas',
            // 'descripcion_accidente_60min',
            // 'id_gerencia',
            // 'correlativo',
            // 'id_naturaleza_accidente',
            // 'ocurrencia_hecho_60m',
            // 'acciones_tomadas_24h',
            // 'observaciones_24h',
            // 'validado_por_24h',
            // 'id_requerimiento_trabajo_24h',
            // 'id_afec_per_categoria',
            // 'id_exposicion_con_cat',
            // 'orden_persona',
        ],
    ]) ?>

</div>
