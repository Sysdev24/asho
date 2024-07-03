<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\AfectacionpersonaSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="afectacion-persona-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_area_afectada') ?>

    <?= $form->field($model, 'id_sub_area_afect') ?>

    <?= $form->field($model, 'id_sub2_area_afect') ?>

    <?= $form->field($model, 'descripcion') ?>

    <?= $form->field($model, 'codigo') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'id_estatus') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
