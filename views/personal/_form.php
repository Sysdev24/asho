<?php

use app\models\Estados;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Estatus;
use app\models\Gerencia;
use app\models\Cargo;
use app\models\Nacionalidad;

/** @var yii\web\View $this */
/** @var app\models\Personal $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="personal-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">
    <?= $form->field($model, 'nacionalidad')->dropDownList(
        ArrayHelper::map(Nacionalidad::find()->all(),'letra','letra'),
        ['prompt'=> 'seleccionar nacionalidad']);?>
         </div>
        <div class="col-md-6">
    <?= $form->field($model, 'ci')->textInput(['placeholder'=>'Ejemplo: 12345678']) ?>
        </div>
    </div>
    <?= $form->field($model, 'nombre')->textInput(['placeholder'=>'escriba su Nombre completo']) ?>

    <?= $form->field($model, 'apellido')->textInput(['placeholder'=>'escriba su Apellido completo']) ?>

    <?= $form->field($model, 'nro_empleado')->textInput(['placeholder'=>'Ejemplo:185555']) ?>

    <?= $form->field($model, 'id_gerencia')->dropDownList(
        ArrayHelper::map(Gerencia::find()->all(),'id_gerencia','descripcion'),
        ['prompt'=> 'seleccionar gerencia']);?>

    <?= $form->field($model, 'id_estado')->dropDownList(
    ArrayHelper::map(Estados::find()->all(),'id_estado','descripcion'),
    ['prompt'=> 'seleccionar estado']);?>

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

    <?= $form->field($model, 'id_cargo')->dropDownList(
        ArrayHelper::map(cargo::find()->all(),'id_cargo','descripcion'),
        ['prompt'=> 'seleccionar Cargo']);?>.


    <?= $form->field($model, 'telefono')->textInput(['placeholder'=>'Ejemplo: 04121234567 ']) ?>
    
    <?= $form->field($model, 'correo')->textInput(['placeholder'=>'nombre@dominio.com'])?>

    
    <?= $form->field($model, 'fecha_nac')->input('date', [
        'min' => '1000-01-01',
        'max' => date('Y-m-d'),
        'class' => 'form-control file',
        'placeholder' => '31/12/1990',
        'required' => true,
    ]) ?>

    


   <!-- En la tabla de registro Falta Algo Verificar OJO-->
    



    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
