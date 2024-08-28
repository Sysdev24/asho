<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Registro $model */

$this->title = $model->id_registro;

\yii\web\YiiAsset::register($this);
?>
<div class="registro-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id_registro' => $model->id_registro], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id_registro' => $model->id_registro], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

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
        ],
    ]) ?>

    <!-- BOTON DE VOLVER-->
    <?= Html::button('Atras', ['class' => 'my-custom-button', 'onclick' => 'goBack()']) ?>

        <script>
            function goBack() {
                window.history.back();
            }
        </script>

    </div>

</div>
