<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Estatus $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="estatus-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'siglas')->textInput(['placeholder'=>'Escriba siglas de estatus']) ?>

    <?= $form->field($model, 'descripcion')->textInput(['placeholder'=>'Escriba nombre del estatus']) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
