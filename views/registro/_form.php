<?php

use app\models\Regiones;
use app\models\Gerencia;
use app\models\Magnitud;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\NaturalezaAccidente;
use yii\web\View;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var app\models\Registro $model */
/** @var app\models\PersonaNatural $modelPersonaNatural */ /** Agrega esta línea **/
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

    <div class="row">
        <div class="col-md-9">
            <?= $form->field($model, 'cedula_reporta')->textInput(['readonly' => true]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'fecha_hora')->textInput(['id' => 'registro-fecha_hora', 'readonly' => true]) ?>
        </div>
    </div>

    <?= $form->field($model, 'id_region')->dropDownList(
        ArrayHelper::map(Regiones::find()->where(['id_estatus' => 1])->all(), 'id_regiones', 'descripcion'),
        ['prompt' => 'Seleccionar región', 'id' => 'region-dropdown']
    ); ?>

    <?= $form->field($model, 'id_estado')->dropDownList(
        [], // Inicialmente vacío
        ['prompt' => 'Seleccionar estado', 'id' => 'estado-dropdown', 'disabled' => true]
    ); ?>

    <?= $form->field($model, 'lugar')->textInput() ?>

    <?= $form->field($model, 'id_gerencia')->textInput(['value' => $gerenciaDescripcion, 'readonly' => true]) ?>
    <?= $form->field($model, 'id_gerencia')->hiddenInput()->label(false); ?>

    <?= $form->field($model, 'id_magnitud')->dropDownList(
        ArrayHelper::map(Magnitud::find()->all(), 'id_magnitud', 'descripcion'),
        ['prompt' => 'Seleccionar la Magnitud del accidente']
    ); ?>

    <?= $form->field($model, 'id_naturaleza_accidente')->dropDownList(
        ArrayHelper::map(NaturalezaAccidente::find()->where(['id_estatus' => 1])->all(), 'id_naturaleza_accidente', 'descripcion'),
        ['prompt' => 'Seleccionar Naturaleza de accidente', 'id' => 'naturaleza-dropdown']
    ) ?>

    <br>
    <h2>Sujeto de Afectación</h2>
    <br>

    <?= $form->field($model, 'cedula_pers_accide')->textInput(['id' => 'cedula-input']) ?>
    <?= Html::button('Validar', ['class' => 'btn btn-primary', 'id' => 'validar-cedula', 'style' => 'display: none;']) ?>

    <div id="personal-fields" style="display: none;">
        <?= Html::label('Nombre', 'nombre_pers_accide') ?>
        <?= Html::textInput('nombre_pers_accide', isset($personalData['nombre']) ? $personalData['nombre'] : '', ['readonly' => true]) ?>

        <?= Html::label('Apellido', 'apellido_pers_accide') ?>
        <?= Html::textInput('apellido_pers_accide', isset($personalData['apellido']) ? $personalData['apellido'] : '', ['readonly' => true]) ?>

        <?= Html::label('Cargo', 'cargo_pers_accide') ?>
        <?= Html::textInput('cargo_pers_accide', isset($personalData['cargo']) ? $personalData['cargo'] : '', ['readonly' => true]) ?>

        <?= Html::label('Nro. Empleado', 'nro_empleado_pers_accide') ?>
        <?= Html::textInput('nro_empleado_pers_accide', isset($personalData['nro_empleado']) ? $personalData['nro_empleado'] : '', ['readonly' => true]) ?>

        <?= Html::label('Teléfono', 'telefono_pers_accide') ?>
        <?= Html::textInput('telefono_pers_accide', isset($personalData['telefono']) ? $personalData['telefono'] : '', ['readonly' => true]) ?>
    </div>

    <div id="persona-natural-fields" style="display: none;">
        <?= $form->field($modelPersonaNatural, 'nombre')->textInput() ?>
        <?= $form->field($modelPersonaNatural, 'apellido')->textInput() ?>
        <?= $form->field($modelPersonaNatural, 'cedula')->textInput() ?>
        <?= $form->field($modelPersonaNatural, 'telefono')->textInput() ?>
        <?= $form->field($modelPersonaNatural, 'fecha_nac')->textInput(['type' => 'date']) ?>
        <?= $form->field($modelPersonaNatural, 'empresa')->textInput() ?>
    </div>

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

    $('#naturaleza-dropdown').change(function() {
        var naturalezaId = $(this).val();
        var cedulaInput = $('#cedula-input');
        var validarButton = $('#validar-cedula');
        var personalFields = $('#personal-fields');
        var personaNaturalFields = $('#persona-natural-fields');

        // Ocultar campos por defecto
        personalFields.hide();
        personaNaturalFields.hide();
        validarButton.hide();

        cedulaInput.off('blur'); // Eliminar eventos anteriores

        if (naturalezaId == 2 || naturalezaId == 19 || naturalezaId == 79) { // LABORAL, NO LABORAL, TRANSITO
            validarButton.show();
            cedulaInput.show();
        } else if (naturalezaId == 31 || naturalezaId == 35) { // TERCERO RELACIONADO, TERCERO NO RELACIONADO
            personaNaturalFields.show();
            cedulaInput.hide();
        } else if (naturalezaId == 61){ //OPERACIONAL
            validarButton.show();
            cedulaInput.show();
        } else {
            cedulaInput.hide();
        }
    });

    $('#validar-cedula').click(function() {
    var cedula = $('#cedula-input').val();
    var naturalezaId = $('#naturaleza-dropdown').val();
    var personalFields = $('#personal-fields');
    var personaNaturalFields = $('#persona-natural-fields');
        if (cedula) {
            $.ajax({
                url: '/registro/buscar-personal',
                data: { cedula: cedula },
                type: 'get',
                success: function(response) {
                    if (response.success) {
                        $('.cedula').text(cedula); // Asignar la cédula
                        $('.nombre').text(response.nombre);
                        $('.apellido').text(response.apellido);
                        $('.cargo').text(response.cargo);
                        $('.nro_empleado').text(response.nro_empleado); // Asignar nro_empleado
                        $('.telefono').text(response.telefono);
                        personalFields.show();
                        personaNaturalFields.hide();
                    } else if (naturalezaId == 61) {
                        personalFields.hide();
                        personaNaturalFields.show();
                    } else {
                        alert('Persona no encontrada');
                        personalFields.hide();
                        personaNaturalFields.hide();
                    }
                }
            });
        }
    });
    ",
    View::POS_READY
);
?>