<?php

use app\models\Estados;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Estatus;
use app\models\Gerencia;
use app\models\Cargo;

/** @var yii\web\View $this */
/** @var app\models\Personal $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="personal-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ci')->textInput() ?>

    <?= $form->field($model, 'nombre')->textInput() ?>

    <?= $form->field($model, 'apellido')->textInput() ?>

    <?= $form->field($model, 'nro_empleado')->textInput() ?>

    <?= $form->field($model, 'id_gerencia')->dropDownList(
        ArrayHelper::map(Gerencia::find()->all(),'id_gerencia','descripcion'),
        ['prompt'=> 'seleccionar gerencia']);?>

    <?= $form->field($model, 'id_estado')->dropDownList(
        ArrayHelper::map(Estados::find()->all(),'id_estado','descripcion'),
        ['prompt'=> 'seleccionar estado']);?>

    <?= $form->field($model, 'id_estatus')->dropDownList(
        ArrayHelper::map(Estatus::find()->all(),'id_estatus','descripcion'),
        ['prompt'=> 'seleccionar status']);?>

    <?= $form->field($model, 'id_cargo')->dropDownList(
        ArrayHelper::map(cargo::find()->all(),'id_cargo','descripcion'),
        ['prompt'=> 'seleccionar id_cargo']);?>


    <?= $form->field($model, 'telefono')->textInput() ?>

    <?= $form->field($model, 'fecha_nac')->textInput() ?>


   <!-- En la tabla de registro Falta Algo Verificar OJO-->
    



    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
