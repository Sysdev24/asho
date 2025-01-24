<?php

use app\models\Regiones;
use app\models\Gerencia;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Estados;
use app\models\NaturalezaAccidente;

/** @var yii\web\View $this */
/** @var app\models\Registro $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="registro-form">

    <?php $form = ActiveForm::begin(); ?>


    <?php
    // Obtener la cédula del usuario logeado
    $user = Yii::$app->user->identity;
    $cedulaReporta = $user->ci;

    // Asignar la cédula al modelo
    $model->cedula_reporta = $cedulaReporta;
    ?>

    <?= $form->field($model, 'cedula_reporta')->textInput(['readonly' => true]) ?>

    <?= $form->field($model, 'fecha_hora')->textInput(['id' => 'registro-fecha_hora']) ?>

    <?= $form->field($model, 'id_region')->dropDownList(
    ArrayHelper::map(Regiones::find()->all(), 'id_regiones', 'descripcion'),
    ['prompt' => 'Seleccionar región', 'id' => 'region-dropdown']
    );?>

    <?= $form->field($model, 'id_estado')->dropDownList(
    [], // Inicialmente vacío
    ['prompt' => 'Seleccionar estado', 'id' => 'estado-dropdown', 'disabled' => true]
    );?>

    <?= $form->field($model, 'lugar')->textInput() ?>

    <?= $form->field($model, 'id_naturaleza_accidente')->dropDownList(
    ArrayHelper::map(NaturalezaAccidente::find()->all(), 'id_naturaleza_accidente', 'descripcion'),
    ['prompt' => 'Seleccionar Naturaleza de accidente']
    ) ?>
    
    <?= $form->field($model, 'id_gerencia')->dropDownList(
    ArrayHelper::map(Gerencia::find()->all(),'id_gerencia','descripcion'),
    ['prompt'=> 'Seleccionar gerencia']);?>


    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$this->registerJs(
"
$(document).ready(function() {
    $('#registro-fecha_hora').val(moment().format('DD-MM-YYYY HH:mm'));
});

$(document).ready(function() {
    $('#region-dropdown').change(function() {
        var regionId = $(this).val();

        if (regionId) {
            $.ajax({
                url: '/registro/get-estados',
                data: { regionId: regionId },
                type: 'get',
                success: function(response) {
                    var estadosData = JSON.parse(response);
                    $('#estado-dropdown').html('').prop('disabled', false);

                    // Agregar el prompt al inicio
                    $('#estado-dropdown').append($('<option>', {
                        value: '',
                        text: 'Seleccionar estado'
                    }));

                    // Agregar las opciones de estados
                    $.each(estadosData, function(id, descripcion) {
                        $('#estado-dropdown').append($('<option>', {
                            value: id,
                            text: descripcion
                        }));
                    });
                }
            });
        } else {
            $('#estado-dropdown').html('').prop('disabled', true);
        }
    });
});

"
);

?>