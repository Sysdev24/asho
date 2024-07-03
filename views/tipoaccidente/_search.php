<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\TipoaccidenteSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="tipo-accidente-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_tipo_accidente') ?>

    <?= $form->field($model, 'id_sub2_tipo_accid') ?>

    <?= $form->field($model, 'id_sub_tipo_accid') ?>

    <?= $form->field($model, 'id_tipo_accid1') ?>

    <?= $form->field($model, 'id_tipo_accid') ?>

    <?php // echo $form->field($model, 'descripcion') ?>

    <?php // echo $form->field($model, 'codigo') ?>

    <?php // echo $form->field($model, 'id_estatus') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
