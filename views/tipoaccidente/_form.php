<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\TipoAccidente $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="tipo-accidente-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_sub2_tipo_accid')->textInput() ?>

    <?= $form->field($model, 'id_sub_tipo_accid')->textInput() ?>

    <?= $form->field($model, 'id_tipo_accid1')->textInput() ?>

    <?= $form->field($model, 'id_tipo_accid')->textInput() ?>

    <?= $form->field($model, 'descripcion')->textInput() ?>

    <?= $form->field($model, 'codigo')->textInput() ?>

    <?= $form->field($model, 'id_estatus')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
