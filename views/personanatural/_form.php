<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Estatus;

/** @var yii\web\View $this */
/** @var app\models\PersonaNatural $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="persona-natural-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre')->textInput() ?>

    <?= $form->field($model, 'apellido')->textInput() ?>

    <?= $form->field($model, 'telefono')->textInput(['placeholder'=>'Ejemplo: 0412-1234567']) ?>

    <?= $form->field($model, 'fecha_nac')->input('date', [
        'min' => '1000-01-01',
        'max' => date('Y-m-d'),
        'class' => 'form-control file',
        'placeholder' => '31/12/1990',
        'required' => true,
    ]) ?>

    <?= $form->field($model, 'id_registro')->textInput() ?>

    <?= $form->field($model, 'empresa')->textInput() ?>

    <?= $form->field($model, 'id_estatus')->dropDownList(
    ArrayHelper::map(
        Estatus::find()
            ->where(['in', 'descripcion', ['ACTIVO', 'INACTIVO']])
            ->all(),
        'id_estatus',
        'descripcion'
    ),
    ['prompt'=> 'seleccionar status']
    );?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
