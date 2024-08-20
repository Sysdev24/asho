<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\RegistroReglaOro $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="registro-regla-oro-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_nro_accidente')->checkbox() ?>

    <?= $form->field($model, 'id_opcion1')->checkbox() ?>

    <?= $form->field($model, 'id_opcion2')->checkbox() ?>

    <?= $form->field($model, 'id_opcion3')->checkbox() ?>

    <?= $form->field($model, 'id_opcion4')->checkbox() ?>

    <?= $form->field($model, 'id_opcion_5')->checkbox() ?>

    <?= $form->field($model, 'id_estatus')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
