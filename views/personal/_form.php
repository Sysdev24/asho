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

// Calcular la fecha máxima permitida (16 años antes de la fecha actual)
$maxDate = date('Y-m-d', strtotime('-16 years'));
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
    ArrayHelper::map(Gerencia::find()->where(['id_estatus' => 1 ])->all(),'id_gerencia','descripcion'),
    ['prompt'=> 'Seleccionar gerencia']
    ); ?>


    <?= $form->field($model, 'id_estado')->dropDownList(
    ArrayHelper::map(Estados::find()->where(['id_estatus' => 1 ])->all(),'id_estado','descripcion'),
    ['prompt'=> 'seleccionar estado']);?>

    <?= $form->field($model, 'id_cargo')->dropDownList(
        ArrayHelper::map(cargo::find()->where(['id_estatus' => 1 ])->all(),'id_cargo','descripcion'),
        ['prompt'=> 'seleccionar Cargo']);?>


    <?= $form->field($model, 'telefono')->textInput(['placeholder'=>'Ejemplo: 04121234567 ']) ?>
    
    <?= $form->field($model, 'correo')->textInput(['placeholder'=>'nombre@dominio.com'])?>

    
    <?= $form->field($model, 'fecha_nac')->input('date', [
        'min' => '1000-01-01',
        'max' => $maxDate, // Fecha máxima permitida (16 años antes de hoy)
        'class' => 'form-control file',
        'placeholder' => '31/12/1990',
        'required' => true,
    ]) ?>

    <?= $form->field($model, 'observacion')->textInput() ?>


    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
//Validación en el Cliente (JavaScript)
$this->registerJs("
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('.personal-form form');
    form.addEventListener('submit', function(event) {
        const fechaNac = document.querySelector('[name=\"Personal[fecha_nac]\"]').value;
        const fechaNacDate = new Date(fechaNac);
        const hoy = new Date();
        let edad = hoy.getFullYear() - fechaNacDate.getFullYear();
        const mes = hoy.getMonth() - fechaNacDate.getMonth();
        if (mes < 0 || (mes === 0 && hoy.getDate() < fechaNacDate.getDate())) {
            edad--;
        }
        if (edad < 16) {
            alert('Debe ser mayor a 16 años para poder registrarse en el sistema.');
            event.preventDefault();
        }
    });
});
");

?>