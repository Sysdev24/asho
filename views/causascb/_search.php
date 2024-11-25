<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\CausascbSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="causas-cb-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_causas_cb') ?>

    <?= $form->field($model, 'id_sub2_fac') ?>

    <?= $form->field($model, 'id_sub_fac') ?>

    <?= $form->field($model, 'id_cau_fac_bas_raiz') ?>

    <?= $form->field($model, 'id_cau_bas_raiz') ?>

    <?php // echo $form->field($model, 'descripcion') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'id_estatus') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
