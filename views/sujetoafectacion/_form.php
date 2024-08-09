<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\SujetoAfectacion $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="sujeto-afectacion-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_clasif_con_afect')->textInput() ?>

    <?= $form->field($model, 'id_con_afectacion')->textInput() ?>

    <?= $form->field($model, 'id_afectacion')->textInput() ?>

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
