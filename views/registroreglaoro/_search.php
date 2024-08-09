<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\RegistroreglaoroSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="registro-regla-oro-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_registro_regla_oro') ?>

    <?= $form->field($model, 'id_nro_accidente')->checkbox() ?>

    <?= $form->field($model, 'id_opcion1')->checkbox() ?>

    <?= $form->field($model, 'id_opcion2')->checkbox() ?>

    <?= $form->field($model, 'id_opcion3')->checkbox() ?>

    <?php // echo $form->field($model, 'id_opcion4')->checkbox() ?>

    <?php // echo $form->field($model, 'id_opcion_5')->checkbox() ?>

    <?php // echo $form->field($model, 'id_estatus') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
