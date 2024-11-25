<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\CausasCb $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="causas-cb-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_sub2_fac')->textInput() ?>

    <?= $form->field($model, 'id_sub_fac')->textInput() ?>

    <?= $form->field($model, 'id_cau_fac_bas_raiz')->textInput() ?>

    <?= $form->field($model, 'id_cau_bas_raiz')->textInput() ?>

    <?= $form->field($model, 'descripcion')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'id_estatus')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
