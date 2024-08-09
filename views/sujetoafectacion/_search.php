<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\SujetoAfectacionSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="sujeto-afectacion-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_sujeto_afect') ?>

    <?= $form->field($model, 'id_clasif_con_afect') ?>

    <?= $form->field($model, 'id_con_afectacion') ?>

    <?= $form->field($model, 'id_afectacion') ?>

    <?= $form->field($model, 'descripcion') ?>

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
