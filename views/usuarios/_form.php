<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Estatus;
use app\models\Gerencia;
use app\models\Roles;

/** @var yii\web\View $this */
/** @var app\models\Usuarios $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="usuarios-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ci')->textInput() ?>

    <?= $form->field($model, 'usuario')->textInput() ?>

    <?= $form->field($model, 'password')->passwordInput() ?>

    <?= $form->field($model, 'nombre')->textInput() ?>

    <?= $form->field($model, 'apellido')->textInput() ?>

    <?= $form->field($model, 'email')->textInput() ?>

    <?= $form->field($model, 'id_estatus')->dropDownList(
    ArrayHelper::map(Estatus::find()->all(),'id_estatus','descripcion'),
    ['prompt'=> 'seleccionar status']);?>

    <?= $form->field($model, 'id_gerencia')->dropDownList(
    ArrayHelper::map(Gerencia::find()->all(),'id_gerencia','descripcion'),
    ['prompt'=> 'Seleccionar Gerencia']);?>

    <?= $form->field($model, 'id_roles')->dropDownList(
    ArrayHelper::map(Roles::find()->all(),'id_roles','descripcion'),
    ['prompt'=> 'Seleccionar Rol']);?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
