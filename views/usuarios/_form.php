<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Estatus;
use app\models\Gerencia;
use app\models\AuthRbac;

/** @var yii\web\View $this */
/** @var app\models\Usuarios $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="usuarios-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ci')->textInput(['placeholder'=>'V-12345678']) ?>

    <?= $form->field($model, 'nombre')->textInput(['placeholder'=>'escriba  su nombre']) ?>

    <?= $form->field($model, 'apellido')->textInput(['placeholder'=>'escriba su apellido']) ?>

    <?= $form->field($model, 'email')->textInput(['placeholder'=>'ejemplo@gmail.com']) ?>

    <?= $form->field($model, 'id_gerencia')->dropDownList(
    ArrayHelper::map(Gerencia::find()->all(),'id_gerencia','descripcion'),
    ['prompt'=> 'Seleccionar Gerencia']);?>

    <?= $form->field($model, 'username')->textInput(['placeholder'=>'Ejemplo: A1234567']) ?>

    <?= $form->field($model, 'password')->passwordInput(['placeholder'=>'escriba su contraseña']) ?>


    <?= $form->field($model, 'id_estatus')->dropDownList(
    ArrayHelper::map(Estatus::find()->all(),'id_estatus','descripcion'),
    ['prompt'=> 'seleccionar status']);?>



    <?= $form->field($model, 'name')->dropDownList(
    ArrayHelper::map(AuthRbac::getRoles(),'name','name'),
    ['prompt'=> 'Seleccionar Gerencia']);?>


    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    

</div>
