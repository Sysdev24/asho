<?php

use app\models\Regiones;
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

    <h3>Quien reporta</h3>
    <br>

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

    <?= $form->field($model, 'id_magnitud')->dropDownList(
        ArrayHelper::map(Magnitud::find()->all(), 'id_magnitud', 'descripcion'),
        ['prompt' => 'Seleccionar la Magnitud del accidente']
    ); ?>

    <?= $form->field($model, 'id_naturaleza_accidente')->dropDownList(
        ArrayHelper::map(NaturalezaAccidente::find()->where(['id_estatus' => 1])->all(), 'id_naturaleza_accidente', 'descripcion'),
        ['prompt' => 'Seleccionar Naturaleza de accidente', 'id' => 'naturaleza-dropdown']
    ) ?>

    <br>
    <h3>Sujeto de Afectación</h3>
    <br>

     SUJETO DE AFECTACIÓN
     <div id="sujeto-afectacion">
        <!-- Campo para ingresar cédula -->
        <div class="input-group mb-3">
            <input type="text" class="form-control" style="width: 150px;" id="searchCedula" name="searchCedula" 
                pattern="[0-9]{8}" required placeholder="Ej. 12345678" 
                oninput="this.value = this.value.replace(/[^0-9]/g, '')">
            <button class="btn btn-primary" type="button" id="boton-validar-cedula">Validar</button>
        </div>

        <div class="container-resp-ajax">
            <p><strong id="origen-data"></strong></p>
            <div class="tabla-datos d-none">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th scope="col" class="tit-cedula">Cédula</th>
                            <th scope="col" class="tit-nombre">Nombre</th>
                            <th scope="col" class="tit-apellido">Apellido</th>
                            <th scope="col" class="tit-cargo">Cargo</th>
                            <th scope="col" class="tit-gerencia">Gerencia</th>
                            <th scope="col" class="tit-nro_empleado">Nro. Empleado</th>
                            <th scope="col" class="tit-telefono">Telefono</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="cedula"></td>
                            <td class="nombre"></td>
                            <td class="apellido"></td>
                            <td class="cargo"></td>
                            <td class="gerencia"></td>
                            <td class="nro_empleado"></td>
                            <td class="telefono"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <?= $form->field($model, 'cedula_pers_accide')->hiddenInput(['id' => 'registro-cedula_pers_accide'])->label(false) ?>
    </div>

    <!-- Persona Natural -->
    <div id="persona-natural" class="d-none">
    <?= $form->field($modelPersonaNatural, 'cedula')->textInput() ?>
        <?= $form->field($modelPersonaNatural, 'nombre')->textInput() ?>
        <?= $form->field($modelPersonaNatural, 'apellido')->textInput() ?>
        <?= $form->field($modelPersonaNatural, 'telefono')->textInput(['placeholder' => 'Ejemplo: 0412-1234567']) ?>
        <?= $form->field($modelPersonaNatural, 'fecha_nac')->input('date', [
            'min' => '1000-01-01',
            'max' => date('Y-m-d'),
            'class' => 'form-control file',
            'placeholder' => '31/12/1990',
        ]) ?>
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
    ",
    View::POS_READY
);
?>

<?php
$this->registerJs(
    "
    $(document).ready(function() {
        // Ocultar el campo de búsqueda de cédula y el botón de validar inicialmente
        $('#busqueda-cedula').hide();
        $('#boton-validar-cedula').hide();

        // Función para limpiar los campos del sujeto de afectación
        function limpiarCamposSujetoAfectacion() {
            $('#searchCedula').val(''); // Limpiar campo de búsqueda de cédula
            $('#origen-data').text(''); // Limpiar mensaje de origen de datos
            $('.tabla-datos').addClass('d-none'); // Ocultar la tabla de datos
            $('#registro-cedula_pers_accide').val(''); // Limpiar campo oculto de cédula
        }

        // Función para limpiar los campos de persona natural
        function limpiarCamposPersonaNatural() {
            $('#personanatural-cedula').val(''); // Limpiar cédula
            $('#personanatural-nombre').val(''); // Limpiar nombre
            $('#personanatural-apellido').val(''); // Limpiar apellido
            $('#personanatural-telefono').val(''); // Limpiar teléfono
            $('#personanatural-fecha_nac').val(''); // Limpiar fecha de nacimiento
            $('#personanatural-empresa').val(''); // Limpiar empresa
        }

        // Manejar el cambio en el dropdown de naturaleza de accidente
        $('#naturaleza-dropdown').change(function() {
            var naturalezaId = $(this).val();

            // Limpiar todos los campos al cambiar la naturaleza
            limpiarCamposSujetoAfectacion();
            limpiarCamposPersonaNatural();

            // Ocultar/mostrar campos según la naturaleza seleccionada
            if (naturalezaId == 2 || naturalezaId == 19 || naturalezaId == 79) { // LABORAL, NO LABORAL, TRANSITO
                $('#busqueda-cedula').show();
                $('#boton-validar-cedula').show();
                $('#persona-natural').addClass('d-none');
            } else if (naturalezaId == 31 || naturalezaId == 35) { // TERCERO RELACIONADO, TERCERO NO RELACIONADO
                $('#busqueda-cedula').hide();
                $('#boton-validar-cedula').hide();
                $('#persona-natural').removeClass('d-none');
            } else { // OPERACIONAL, AMBIENTAL
                $('#busqueda-cedula').hide();
                $('#boton-validar-cedula').hide();
                $('#persona-natural').addClass('d-none');
            }
        });

        // Validar cédula
        $('#boton-validar-cedula').on('click', function(e) {
            e.preventDefault();
            var search = $('#searchCedula').val();

            if (search.length < 8) {
                alert('La cédula debe tener al menos 8 dígitos.');
                return;
            }

            $.ajax({
                url: '" . Url::toRoute('registro/validar-cedula') . "',
                type: 'post',
                dataType: 'json',
                data: {search: search}
            })
            .done(function(response) {
                if (!response.ci) {
                    $('#origen-data').removeClass('text-success').addClass('text-danger').text('La cédula no se encuentra en el sistema.');
                    return;
                }

                $('#origen-data').removeClass('text-danger').addClass('text-success').text('Datos encontrados en Personal.');
                $('.tabla-datos').removeClass('d-none');
                $('.cedula').text(response.ci);
                $('.nombre').text(response.nombre);
                $('.apellido').text(response.apellido);
                $('.cargo').text(response.cargo);
                $('.gerencia').text(response.gerencia);
                $('.nro_empleado').text(response.nro_empleado);
                $('.telefono').text(response.telefono);
                $('#registro-cedula_pers_accide').val(response.ci);
            })
            .fail(function() {
                $('#origen-data').removeClass('text-success').addClass('text-danger').text('Error al validar la cédula.');
            });
        });
    });
    ",
    View::POS_READY,
    'validacion_cedula'
);
?>