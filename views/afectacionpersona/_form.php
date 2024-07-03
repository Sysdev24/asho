<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\AfectacionPersona $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="afectacion-persona-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_sub_area_afect')->textInput() ?>

    <?= $form->field($model, 'id_sub2_area_afect')->textInput() ?>

    <?= $form->field($model, 'descripcion')->textInput() ?>

    <?= $form->field($model, 'codigo')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'id_estatus')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
