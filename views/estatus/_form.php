<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Estatus $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="estatus-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'siglas')->textInput() ?>

    <?= $form->field($model, 'descripcion')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
