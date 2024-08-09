<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\AfectacionbienesprocesosSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="afectacion-bienes-procesos-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_afec_bien_pro') ?>

    <?= $form->field($model, 'afectacion') ?>

    <?= $form->field($model, 'valor') ?>

    <?= $form->field($model, 'created_at') ?>

    <?= $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'id_estatus') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
