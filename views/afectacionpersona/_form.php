<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Estatus;

/** @var yii\web\View $this */
/** @var app\models\AfectacionPersona $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="afectacion-persona-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'descripcion')->textInput() ?>

    <?= $form->field($model, 'codigo')->textInput() ?>

    <?= $form->field($model, 'estatus')->dropDownList(
        ArrayHelper::map(Estatus::find()->all(),'id_estatus','descripcion'),
        ['prompt'=> 'seleccionar status']);?>

    

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
