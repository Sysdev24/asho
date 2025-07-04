<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\TipoTrabajo;
use app\models\PeliAgenCategoria;

/** @var yii\web\View $this */
/** @var app\models\SegundaPantalla $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="segunda-pantalla-form">

    <?php $form = ActiveForm::begin(); ?>


    <?= Html::activeLabel($model, 'id_estatus_proceso') ?>
    <?= Html::textInput('estatus', $model->estatusProceso->descripcion ?? 'No definido', [
        'class' => 'form-control',
        'readonly' => true
    ]) ?>
    <br>

    <?= $form->field($model, 'cedula_pers_accide')->textInput(['readonly' => true]) ?>

    <?= $form->field($model, 'cedula_validad_60min')->textInput() ?>

    <?= $form->field($model, 'id_tipo_accidente')->textInput() ?>

    <?= $form->field($model, 'id_tipo_trabajo')->dropDownList(
        ArrayHelper::map(TipoTrabajo::find()->all(), 'id_tipo_trabajo', 'descripcion'),
        ['prompt' => 'Seleccionar el tipo de trabajo']
    ); ?>

    <?= $form->field($model, 'id_peligro_agente')->textInput() ?>

    <?= $form->field($model, 'id_sujeto_afectacion')->textInput() ?>

    <?= $form->field($model, 'cedula_24horas')->textInput() ?>

    <?= $form->field($model, 'acciones_tomadas_24horas')->textInput() ?>

    <?= $form->field($model, 'observaciones_24horas')->textInput() ?>

    <?= $form->field($model, 'recomendaciones_24horas')->textInput() ?>

    <?= $form->field($model, 'autorizado_24horas')->checkbox() ?>

    <?= $form->field($model, 'cedula_valid_24horas')->textInput() ?>

    <?= $form->field($model, 'acciones_tomadas_24h')->textInput() ?>

    <?= $form->field($model, 'observaciones_24h')->textInput() ?>

    <?= $form->field($model, 'validado_por_24h')->textInput() ?>

    <?= $form->field($model, 'id_requerimiento_trabajo_24h')->textInput() ?>

    <?= $form->field($model, 'id_afec_per_categoria')->textInput() ?>

    <?= $form->field($model, 'id_exposicion_con_cat')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
