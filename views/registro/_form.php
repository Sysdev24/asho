<?php

use app\models\Regiones;
use app\models\Gerencia;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Estados;
use app\models\NaturalezaAccidente;
use yii\web\View;
use yii\helpers\Url;

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

<div class="row">
        <div class="col-md-9">
    
	<?= $form->field($model, 'cedula_reporta')->textInput(['readonly' => true]) ?>
         </div>
        <div class="col-md-3">
    <?= $form->field($model, 'fecha_hora')->textInput(['id' => 'registro-fecha_hora', 'readonly' => true]) ?>
    
        </div>
    </div>

    <?= $form->field($model, 'id_region')->dropDownList(
    ArrayHelper::map(Regiones::find()->where(['id_estatus' => 1 ])->all(), 'id_regiones', 'descripcion'),
    ['prompt' => 'Seleccionar región', 'id' => 'region-dropdown']
    );?>

    <?= $form->field($model, 'id_estado')->dropDownList(
    [], // Inicialmente vacío
    ['prompt' => 'Seleccionar estado', 'id' => 'estado-dropdown', 'disabled' => true]
    );?>

    <?= $form->field($model, 'lugar')->textInput() ?>

    <?= $form->field($model, 'id_naturaleza_accidente')->dropDownList(
    ArrayHelper::map(NaturalezaAccidente::find()->where(['id_estatus' => 1 ])->all(), 'id_naturaleza_accidente', 'descripcion'),
    ['prompt' => 'Seleccionar Naturaleza de accidente']
    ) ?>
    
    <?= $form->field($model, 'id_gerencia')->dropDownList(
    ArrayHelper::map(Gerencia::find()->where(['id_estatus' => 1 ])->all(),'id_gerencia','descripcion'),
    ['prompt'=> 'Seleccionar gerencia']);?>



    <!-- SUJETO DE AFECTACION -->


    <div class="input-group mb-3">
        <input type="text" class="form-control" style="width: 150px;" id="searchCedula" name="searchCedula" pattern="[0-9]{8}" required placeholder="Ej. 12345678" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
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
                        <td class="nro_empleado"></td>
                        <td class="telefono"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <?= $form->field($model, 'cedula_pers_accide')->hiddenInput()->label(false) ?> <!-- Campo oculto para cédula -->



    <!-- Persona Natural -->
    <div class="persona-natural d-none" >

    <?= $form->field($modelPersonaNatural, 'cedula')->hiddenInput()->label(false) ?> <!-- Campo oculto para cédula -->
    
    <?= $form->field($modelPersonaNatural, 'nombre')->textInput() ?>

    <?= $form->field($modelPersonaNatural, 'apellido')->textInput() ?>

    <?= $form->field($modelPersonaNatural, 'telefono')->textInput(['placeholder'=>'Ejemplo: 0412-1234567']) ?>

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

"
);

// Registrar el script solo si el escenario es 'create'

    $this->registerJs(
        "
        // Validando cédula
        $('#boton-validar-cedula').on('click', function(e) {
            e.preventDefault();
            // Obtener la cédula a validar
            var search = $('#searchCedula').val();

            // Validación de la longitud de la cédula
            if (search.length < 8) {
                // Mostrar un mensaje de error
                alert('La cédula debe tener al menos 8 dígitos.');
                return; // Detenemos la ejecución de la función si la cédula es demasiado corta
            }

            //alert('Datos: ' + search);
            // Mostrar mensaje de espera
            $('p strong#origen-data')
                .removeClass('text-success text-danger text-info')
                .addClass('text-secondary')
                .text('Espere...');
            // Ocultar/mostrar tabla de resultados
            $('div.container-resp-ajax div.tabla-datos').addClass('d-none');
            $('#registro-ci').val('');
            $.ajax({
                url: '" . Url::toRoute('registro/validar-cedula') . "',
                type: 'post',
                dataType: 'json',
                data: {search: search}
            })
            .done(function(response) {
                // Validación caso extraordinario
                if (!response.ci) {
                    $('p strong#origen-data')
                        .removeClass('text-secondary text-info text-success')
                        .addClass('text-danger')
                        .text('La cédula no se encuentra en el sistema. Regístrela primero.');
                    $('div.persona-natural').removeClass('d-none');
                    $('#personanatural-cedula').val(response.cedula);

                    return;

                }
                
                // Si se encuentra la cédula, mostrar los datos
                $('p strong#origen-data')
                    .removeClass('text-secondary text-info text-danger')
                    .addClass('text-success')
                    .text('Datos encontrados en Personal.');
                $('div.container-resp-ajax div.tabla-datos').removeClass('d-none');
                $('div.container-resp-ajax div.tabla-datos table thead tr th.d-none').removeClass('d-none');
                $('div.container-resp-ajax div.tabla-datos table tbody tr td.d.none').removeClass('d-none');
                $('div.container-resp-ajax div.tabla-datos table tbody tr td.cedula').text(response.ci);
                $('div.container-resp-ajax div.tabla-datos table tbody tr td.nombre').text(response.nombre);
                $('div.container-resp-ajax div.tabla-datos table tbody tr td.apellido').text(response.apellido);
                $('div.container-resp-ajax div.tabla-datos table tbody tr td.cargo').text(response.cargo);
                $('div.container-resp-ajax div.tabla-datos table tbody tr td.nro_empleado').text(response.nro_empleado);
                $('div.container-resp-ajax div.tabla-datos table tbody tr td.telefono').text(response.telefono);
                // Llenar el campo oculto con la cédula
                $('#registro-cedula_pers_accide').val(response.ci);
                $('div.persona-natural').addClass('d-none');
            })
            .fail(function() {
                console.log('Error al enviar el ajax');
                $('p strong#origen-data')
                    .removeClass('text-secondary text-success text-info')
                    .addClass('text-danger')
                    .text('Error al validar la cédula. Inténtelo nuevamente.');
            });
        });

        // Inhabilitar botón en caso de que esté vacío el campo cédula
        $('#boton-validar-cedula').attr('disabled', true);
        $('#searchCedula').on('input', function(e) {
            if ($('#searchCedula').val() != '' || $('#searchCedula').val() != null) {
                $('#boton-validar-cedula').attr('disabled', false);
            } else {
                $('#boton-validar-cedula').attr('disabled', true);
            }
        });
        ",
        View::POS_READY,
        'validacion_cedula'
    );


?>