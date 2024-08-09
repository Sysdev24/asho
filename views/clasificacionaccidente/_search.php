<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\ClasificacionaccidenteSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="clasificacion-accidente-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_clasif_accid_lab_ope_amb') ?>

    <?= $form->field($model, 'descripcion') ?>

    <?= $form->field($model, 'codigo') ?>

    <?= $form->field($model, 'id_estatus') ?>

    <?= $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
