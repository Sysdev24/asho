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



    <div id="naturalezas-adicionales">
        <?= $form->field($model, 'id_naturaleza_accidente')->dropDownList(
            ArrayHelper::map(NaturalezaAccidente::find()->where(['id_estatus' => 1])->all(), 'id_naturaleza_accidente', 'descripcion'),
            ['prompt' => 'Seleccionar Naturaleza de accidente', 'id' => 'naturaleza-dropdown']
        ) ?>
    </div>

    <!-- Botón para agregar naturaleza adicional (inicialmente visible) -->
    <button type="button" id="agregar-naturaleza" class="btn btn-success" style="margin-bottom: 15px;">
        <i class="fa fa-plus"></i>
    </button>

    <div id="sujeto-afectacion-container" class="d-none">
    <br>
    <h3>Sujeto(s) de Afectación</h3>
    <br>
    </div>

    <!-- Contenedor para personas -->
    <div id="personas-container">
        <!-- Persona inicial -->
        <div class="persona-wrapper" data-index="0">
            <div class="card mb-3 d-none">
                <div class="card-header">
                    <h5 class="card-title">Persona #1</h5>
                    <button type="button" class="btn btn-danger btn-sm float-right eliminar-persona" style="display: none;">
                        <i class="fa fa-trash"></i> Eliminar
                    </button>
                </div>
                <div class="card-body">
                    <!-- SUJETO DE AFECTACIÓN -->
                    <div class="sujeto-afectacion">
                        <div class="input-group mb-3 busqueda-cedula d-none">
                            <input type="text" class="form-control" style="width: 150px;" id="searchCedula_0" name="searchCedula[]" pattern="[0-9]{8}" placeholder="Ingresar Cédula. Ej. 12345678" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                            <button class="btn btn-primary validar-cedula-btn" type="button" data-index="0">
                                Validar
                            </button>
                        </div> 

                        <div class="container-resp-ajax">
                            <p><strong class="origen-data"></strong></p>
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

                        <input type="hidden" class="registro-cedula_pers_accide" name="Registro[cedula_pers_accide][]">
                    </div>

                    <!-- Persona Natural -->
                    <div class="persona-natural d-none">
                        <?= $form->field($modelPersonaNatural[0], "[0]cedula")->textInput() ?>
                        <?= $form->field($modelPersonaNatural[0], "[0]nombre")->textInput() ?>
                        <?= $form->field($modelPersonaNatural[0], "[0]apellido")->textInput() ?>
                        <?= $form->field($modelPersonaNatural[0], "[0]telefono")->textInput(['placeholder' => 'Ejemplo: 0412-1234567']) ?>
                        <?= $form->field($modelPersonaNatural[0], "[0]fecha_nac")->input('date', [
                            'min' => '1000-01-01',
                            'max' => date('Y-m-d'),
                            'class' => 'form-control file',
                            'placeholder' => '31/12/1990',
                        ]) ?>
                        <?= $form->field($modelPersonaNatural[0], "[0]empresa")->textInput() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Botón para agregar otra persona -->
    <button type="button" id="agregar-persona" class="btn btn-primary d-none">
        <i class="fa fa-plus"></i> Agregar otra persona
    </button>

    <div id="sub-container">
    <br>
    <h3>Supervisor</h3>
    <br>
    </div>

    <!-- Campo Supervisor - Dependiente de la naturaleza -->
    <div id="supervisor-container">
        <div class="supervisor-wrapper">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="supervisor-buscar">
                        <div class="input-group mb-3 busqueda-supervisor d-none">
                            <input type="text" class="form-control" style="width: 150px;" id="searchCedulaSup" name="searchCedulaSup" pattern="[0-9]{8}" placeholder="Ingresar Cédula. Ej. 12345678" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                            <button class="btn btn-primary" type="button" id="boton-validar-supervisor">Validar</button>
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
                                            <th scope="col" class="tit-telefono">Telefono</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="cedula"></td>
                                            <td class="nombre"></td>
                                            <td class="apellido"></td>
                                            <td class="telefono"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <?= $form->field($model, 'cedula_supervisor_60min')->hiddenInput()->label(false) ?> <!-- Campo oculto para cédula -->
                    </div>

                    <!-- Supervisor Manual -->
                    <div class="supervisor-manual d-none">
                            <?= $form->field($modelPersonaNatural[0], "[0]cedula")->textInput() ?>
                            <?= $form->field($modelPersonaNatural[0], "[0]nombre")->textInput() ?>
                            <?= $form->field($modelPersonaNatural[0], "[0]apellido")->textInput() ?>
                            <?= $form->field($modelPersonaNatural[0], "[0]telefono")->textInput(['placeholder' => 'Ejemplo: 0412-1234567']) ?>
                            <?= $form->field($modelPersonaNatural[0], "[0]empresa")->textInput() ?>
                        </div>
                </div>
            </div>
        </div>
    </div>

    <?= $form->field($model, 'observaciones_60min')->textInput() ?>

    <?= $form->field($model, 'acciones_tomadas_60min')->textInput() ?>

    <?= $form->field($model, 'descripcion_accidente_60min')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

//Script para fecha/hora y combo de región/estadi
$this->registerJs(
    "
    $(document).ready(function() {

        $('#registro-fecha_hora').val(moment().format('DD-MM-YYYY HH:mm'));

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

// JavaScript para manejar la adición, eliminación y validación de naturalezas
$this->registerJs(
    "
    $(document).ready(function() {
        var naturalezaCount = 0;
        var maxNaturalezas = 1; // Solo permitir una adicional
        
        // Función para deshabilitar opciones ya seleccionadas
        function actualizarOpciones() {
            var seleccionPrincipal = $('#naturaleza-dropdown').val();
            var seleccionAdicional = $('#naturaleza-dropdown-adicional').val();
            
            // Deshabilitar en principal lo seleccionado en adicional
            $('#naturaleza-dropdown option').prop('disabled', false);
            if (seleccionAdicional) {
                $('#naturaleza-dropdown option[value=\"' + seleccionAdicional + '\"]').prop('disabled', true);
                if ($('#naturaleza-dropdown').val() == seleccionAdicional) {
                    $('#naturaleza-dropdown').val('');
                }
            }
            
            // Deshabilitar en adicional lo seleccionado en principal
            if ($('#naturaleza-dropdown-adicional').length) {
                $('#naturaleza-dropdown-adicional option').prop('disabled', false);
                if (seleccionPrincipal) {
                    $('#naturaleza-dropdown-adicional option[value=\"' + seleccionPrincipal + '\"]').prop('disabled', true);
                    if ($('#naturaleza-dropdown-adicional').val() == seleccionPrincipal) {
                        $('#naturaleza-dropdown-adicional').val('');
                    }
                }
            }
        }
        
        // Aplicar validación al cambiar cualquier dropdown
        $(document).on('change', '#naturaleza-dropdown, #naturaleza-dropdown-adicional', function() {
            actualizarOpciones();
        });
        
        $('#agregar-naturaleza').click(function() {
            if (naturalezaCount < maxNaturalezas) {
                // Crear un ID único para el nuevo contenedor
                var nuevoId = 'naturaleza-adicional-' + Date.now();
                
                // Clonar el dropdown y limpiar su valor
                var nuevoDropdown = $('#naturaleza-dropdown').clone()
                    .attr('id', 'naturaleza-dropdown-adicional')
                    .attr('name', 'naturaleza_adicional')
                    .val('');
                
                // Crear el botón de eliminar
                var botonEliminar = $('<button>')
                    .attr('type', 'button')
                    .addClass('btn btn-danger btn-sm btn-eliminar-naturaleza')
                    .html('<i class=\"fa fa-trash\"></i>')
                    .css({
                        'margin-left': '10px',
                        'vertical-align': 'middle'
                    })
                    .click(function() {
                        $('#' + nuevoId).remove();
                        naturalezaCount--;
                        $('#agregar-naturaleza').show();
                        actualizarOpciones(); // Re-activar las opciones al eliminar
                    });
                
                // Crear el contenedor completo
                var contenedor = $('<div>')
                    .attr('id', nuevoId)
                    .addClass('naturaleza-adicional-container')
                    .css('margin-top', '15px')
                    .append(
                        $('<div>').addClass('form-group field-naturaleza-adicional').append(
                            $('<label>').addClass('control-label').text('Naturaleza Adicional'),
                            $('<div>').addClass('input-group').append(
                                nuevoDropdown,
                                $('<div>').addClass('input-group-append').append(
                                    botonEliminar
                                )
                            )
                        )
                    );
                
                // Agregar al contenedor principal
                $('#naturalezas-adicionales').append(contenedor);
                
                naturalezaCount++;
                
                // Ocultar el botón si ya se alcanzó el máximo
                if (naturalezaCount >= maxNaturalezas) {
                    $(this).hide();
                }
                
                // Actualizar opciones después de agregar
                actualizarOpciones();
            }
        });
        
        // Validación inicial
        actualizarOpciones();
    });
    ",
    View::POS_READY
);

//Script para añadir multiples personas dependiendo de la naturaleza
$this->registerJs(
    "
    // Manejo de personas
    $(document).ready(function() {
        // Manejo de personas
        var personaCounter = 1;

        // Agregar nueva persona
        $('#agregar-persona').click(function() {
            var newIndex = personaCounter++;
            var newPersona = $('.persona-wrapper:first').clone();

            // Actualizar todos los IDs y nombres
            newPersona.attr('data-index', newIndex);
            newPersona.find('.card-title').text('Persona #' + (newIndex + 1));
            newPersona.find('.eliminar-persona').show();

            // Limpiar campos
            newPersona.find('input').val('');
            newPersona.find('.tabla-datos').addClass('d-none');
            newPersona.find('.origen-data').text('');

            // Actualizar IDs y nombres de los campos
            newPersona.find('[id]').each(function() {
                var oldId = $(this).attr('id');
                if (oldId) {
                    $(this).attr('id', oldId.replace(/_0$/, '_' + newIndex));
                }
            });

            newPersona.find('[name]').each(function() {
                var name = $(this).attr('name');
                if (name && name.match(/\[\d+\]/)) {
                    $(this).attr('name', name.replace(/\[\d+\]/, '[' + newIndex + ']'));
                }
            });

            // Agregar al contenedor
            $('#personas-container').append(newPersona);

            // Mostrar botón de eliminar en la primera persona si hay más de una
            if (personaCounter > 1) {
                $('.persona-wrapper:first .eliminar-persona').show();
            }
        });

        // Eliminar persona
        $(document).on('click', '.eliminar-persona', function() {
            var wrapper = $(this).closest('.persona-wrapper');
            var index = wrapper.attr('data-index');

            // No permitir eliminar la última persona
            if ($('.persona-wrapper').length > 1) {
                wrapper.remove();

                // Reindexar los wrappers restantes
                $('.persona-wrapper').each(function(i) {
                    $(this).attr('data-index', i);
                    $(this).find('.card-title').text('Persona #' + (i + 1));

                    // Actualizar IDs y nombres
                    $(this).find('[id]').each(function() {
                        var oldId = $(this).attr('id');
                        if (oldId) {
                            $(this).attr('id', oldId.replace(/_(\d+)$/, '_' + i));
                        }
                    });

                    $(this).find('[name]').each(function() {
                        var name = $(this).attr('name');
                        if (name && name.match(/\[\d+\]/)) {
                            $(this).attr('name', name.replace(/\[\d+\]/, '[' + i + ']'));
                        }
                    });
                });

                personaCounter--;

                // Ocultar botón de eliminar si solo queda una persona
                if ($('.persona-wrapper').length === 1) {
                    $('.persona-wrapper .eliminar-persona').hide();
                }
            }
        });

        // Manejar cambio en naturaleza de accidente para todas las personas
        $(document).on('change', '#naturaleza-dropdown, #naturaleza-dropdown-adicional', function() {
            var naturalezaId = $('#naturaleza-dropdown').val();
            var sujetoAfectacionContainer = $('#sujeto-afectacion-container');
            var btnAgregarPersona = $('#agregar-persona');

            // IDs de naturalezas que NO deben mostrar el título (AMBIENTAL y OPERACIONAL)
            var naturalezasSinTitulo = [61, 92];
            var naturalezasSinPersonas = [61, 92]; // Mismos IDs que no permiten personas

            $('.persona-wrapper').each(function() {
                var wrapper = $(this);

                // Limpiar campos
                wrapper.find('.busqueda-cedula input').val('');
                wrapper.find('.origen-data').text('');
                wrapper.find('.tabla-datos').addClass('d-none');
                wrapper.find('.registro-cedula_pers_accide').val('');
                wrapper.find('.persona-natural input').val('');

                // Mostrar/ocultar título según naturaleza
                if (naturalezaId && !naturalezasSinTitulo.includes(parseInt(naturalezaId))) {
                    wrapper.find('.card').removeClass('d-none'); // Mostrar título
                } else {
                    wrapper.find('.card').addClass('d-none'); // Ocultar título
                }

                // Mostrar/ocultar secciones según naturaleza
                if (naturalezaId == 2 || naturalezaId == 19 || naturalezaId == 79) { // LABORAL, NO LABORAL, TRANSITO
                    wrapper.find('.busqueda-cedula').removeClass('d-none'); // Mostrar búsqueda de cédula
                    wrapper.find('.busqueda-cedula').show();
                    wrapper.find('.persona-natural').addClass('d-none');
                } else if (naturalezaId == 31 || naturalezaId == 35) { // TERCERO RELACIONADO, TERCERO NO RELACIONADO
                    wrapper.find('.busqueda-cedula').addClass('d-none');
                    wrapper.find('.persona-natural').removeClass('d-none');
                } else { // OPERACIONAL, AMBIENTAL
                    wrapper.find('.busqueda-cedula').addClass('d-none');
                    wrapper.find('.persona-natural').addClass('d-none');
                }
            });

            if (naturalezaId && !naturalezasSinPersonas.includes(parseInt(naturalezaId))) {
                btnAgregarPersona.removeClass('d-none'); // Mostrar botón
                sujetoAfectacionContainer.removeClass('d-none'); // Mostrar sección
            } else {
                btnAgregarPersona.addClass('d-none'); // Ocultar botón
                sujetoAfectacionContainer.addClass('d-none'); // Ocultar sección
            }
        });
    });
    ",
    View::POS_READY,
);

//Validacion de cedula personal
$this->registerJs(
    "
    // Función para verificar cédulas duplicadas
    function verificarCedulasDuplicadas(wrapperActual) {
        var cedulasIngresadas = [];
        var hayDuplicados = false;
        
        // Obtener todas las cédulas ingresadas (tanto de personal como naturales)
        $('.busqueda-cedula input[type=\"text\"], .persona-natural input[id$=\"-cedula\"]').each(function() {
            var cedula = $(this).val();
            if (cedula && cedula.length >= 8) {
                if (cedulasIngresadas.includes(cedula)) {
                    hayDuplicados = true;
                    // Mostrar mensaje de error
                    var errorContainer = $(this).closest('.form-group').find('.help-block');
                    if (!errorContainer.length) {
                        errorContainer = $(this).closest('.persona-wrapper').find('.origen-data');
                    }
                    errorContainer.removeClass('text-success')
                                 .addClass('text-danger')
                                 .text('Esta cédula ya está registrada en otra persona');
                }
                cedulasIngresadas.push(cedula);
            }
        });
        
        return hayDuplicados;
    }

    // Validación para personal
    $(document).on('click', '.validar-cedula-btn', function() {
        var wrapper = $(this).closest('.persona-wrapper');
        var search = wrapper.find('input[id^=\"searchCedula_\"]').val();
        var naturalezaId = $('#naturaleza-dropdown').val();

        // Verificar duplicados antes de validar
        if (verificarCedulasDuplicadas(wrapper)) {
            return;
        }

        if (!/^[0-9]{8,}$/.test(search)) {
            wrapper.find('.origen-data').removeClass('text-success')
                                      .addClass('text-danger')
                                      .text('La cédula debe tener al menos 8 dígitos y solo contener números.');
            return;
        }

        if (naturalezaId == 2 || naturalezaId == 19 || naturalezaId == 79) {
            $.ajax({
                url: '".Url::to(['registro/validar-cedula'])."',
                type: 'post',
                dataType: 'json',
                data: {search: search}
            })
            .done(function(response) {
                // Verificar nuevamente por si hubo cambios
                if (verificarCedulasDuplicadas(wrapper)) {
                    return;
                }

                if (!response.ci) {
                    wrapper.find('.origen-data').removeClass('text-success')
                                              .addClass('text-danger')
                                              .text('La cédula no se encuentra en el sistema.');
                    wrapper.find('.registro-cedula_pers_accide').val('');
                    return;
                }

                wrapper.find('.origen-data').removeClass('text-danger')
                                          .addClass('text-success')
                                          .text('Datos encontrados en Personal.');
                wrapper.find('.tabla-datos').removeClass('d-none');
                wrapper.find('.cedula').text(response.ci);
                wrapper.find('.nombre').text(response.nombre);
                wrapper.find('.apellido').text(response.apellido);
                wrapper.find('.cargo').text(response.cargo);
                wrapper.find('.gerencia').text(response.gerencia);
                wrapper.find('.nro_empleado').text(response.nro_empleado);
                wrapper.find('.telefono').text(response.telefono);
                wrapper.find('.registro-cedula_pers_accide').val(response.ci);
            })
            .fail(function() {
                wrapper.find('.origen-data')
                    .removeClass('text-success')
                    .addClass('text-danger')
                    .text('Error al validar la cédula.');
            });
        }
    });

    // Validación en tiempo real para todos los campos de cédula
    $(document).on('change keyup', '.busqueda-cedula input[type=\"text\"], .persona-natural input[id$=\"-cedula\"]', function() {
        var currentCedula = $(this).val();
        
        if (currentCedula.length >= 8) {
            // Verificar duplicados
            var count = 0;
            $('.busqueda-cedula input[type=\"text\"], .persona-natural input[id$=\"-cedula\"]').each(function() {
                if ($(this).val() === currentCedula && $(this).val().length >= 8) {
                    count++;
                }
            });
            
            var errorContainer = $(this).closest('.form-group').find('.help-block');
            if (!errorContainer.length) {
                errorContainer = $(this).closest('.persona-wrapper').find('.origen-data');
            }
            
            if (count > 1) {
                errorContainer.removeClass('text-success')
                             .addClass('text-danger')
                             .text('Esta cédula ya está registrada en otra persona');
            } else {
                errorContainer.text('').removeClass('text-danger text-success');
            }
        }
    });

    // Manejo de agregar/eliminar personas
    var personaCounter = 1;
    

    $(document).on('click', '.eliminar-persona', function() {
        var wrapper = $(this).closest('.persona-wrapper');
        
        if ($('.persona-wrapper').length > 1) {
            wrapper.remove();
            
            // Reindexar
            $('.persona-wrapper').each(function(i) {
                $(this).attr('data-index', i);
                $(this).find('.card-title').text('Persona #' + (i + 1));
                $(this).find('[id]').each(function() {
                    var oldId = $(this).attr('id');
                    if (oldId) {
                        $(this).attr('id', oldId.replace(/_(\d+)$/, '_' + i));
                    }
                });
                $(this).find('[name]').each(function() {
                    var name = $(this).attr('name');
                    if (name && name.match(/\[\d+\]/)) {
                        $(this).attr('name', name.replace(/\[\d+\]/, '[' + i + ']'));
                    }
                });
            });
            
            personaCounter--;
            
            if ($('.persona-wrapper').length === 1) {
                $('.persona-wrapper .eliminar-persona').hide();
            }
            
            // Verificar duplicados después de eliminar
            verificarCedulasDuplicadas();
        }
    });

    // Manejar cambio en naturaleza de accidente
    $(document).on('change', '#naturaleza-dropdown, #naturaleza-dropdown-adicional', function() {
        var naturalezaId = $('#naturaleza-dropdown').val();
        var naturalezasSinPersonas = [61, 92];
        
        $('.persona-wrapper').each(function() {
            var wrapper = $(this);
            wrapper.find('input').val('');
            wrapper.find('.tabla-datos').addClass('d-none');
            wrapper.find('.origen-data, .help-block').text('').removeClass('text-danger text-success');

            if (naturalezaId == 2 || naturalezaId == 19 || naturalezaId == 79) {
                wrapper.find('.busqueda-cedula').removeClass('d-none');
                wrapper.find('.persona-natural').addClass('d-none');
            } else if (naturalezaId == 31 || naturalezaId == 35) {
                wrapper.find('.busqueda-cedula').addClass('d-none');
                wrapper.find('.persona-natural').removeClass('d-none');
            } else {
                wrapper.find('.busqueda-cedula, .persona-natural').addClass('d-none');
            }
        });

        if (naturalezaId && !naturalezasSinPersonas.includes(parseInt(naturalezaId))) {
            $('#agregar-persona, #sujeto-afectacion-container').removeClass('d-none');
        } else {
            $('#agregar-persona, #sujeto-afectacion-container').addClass('d-none');
        }
    });
    ",
    View::POS_READY,
    'validacion-personas'
);

//Validar cedula del supervisor
$this->registerJs(
    "
    // Validación para supervisor
    $(document).on('click', '#boton-validar-supervisor', function() {
        var wrapper = $(this).closest('.supervisor-wrapper');
        var search = $('#searchCedulaSup').val();
        var naturalezaId = $('#naturaleza-dropdown').val();

        // Verificar duplicados antes de validar
        if (verificarCedulasDuplicadas(wrapper)) {
            return;
        }

        if (!/^[0-9]{8,}$/.test(search)) {
            wrapper.find('.origen-data').removeClass('text-success')
                                      .addClass('text-danger')
                                      .text('La cédula debe tener al menos 8 dígitos y solo contener números.');
            return;
        }

        if (naturalezaId == 2 || naturalezaId == 19 || naturalezaId == 79) {
            $.ajax({
                url: '".Url::to(['registro/validar-cedula'])."',
                type: 'post',
                dataType: 'json',
                data: {search: search}
            })
            .done(function(response) {
                // Verificar nuevamente por si hubo cambios
                if (verificarCedulasDuplicadas(wrapper)) {
                    return;
                }

                if (!response.ci) {
                    wrapper.find('.origen-data').removeClass('text-success')
                                              .addClass('text-danger')
                                              .text('La cédula no se encuentra en el sistema.');
                    wrapper.find('.registro-cedula_supervisor_60min').val('');
                    return;
                }

                wrapper.find('.origen-data').removeClass('text-danger')
                                          .addClass('text-success')
                                          .text('Datos encontrados en Personal.');
                wrapper.find('.tabla-datos').removeClass('d-none');
                wrapper.find('.cedula').text(response.ci);
                wrapper.find('.nombre').text(response.nombre);
                wrapper.find('.apellido').text(response.apellido);
                wrapper.find('.telefono').text(response.Telefono);
                wrapper.find('.empresa').text(response.Empresa);
                wrapper.find('.registro-cedula_supervisor_60min').val(response.ci);
            })
            .fail(function() {
                wrapper.find('.origen-data')
                    .removeClass('text-success')
                    .addClass('text-danger')
                    .text('Error al validar la cédula.');
            });
        }
    });

    // Manejar cambio en naturaleza de accidente
    $(document).on('change', '#naturaleza-dropdown, #naturaleza-dropdown-adicional', function() {
        var naturalezaId = $('#naturaleza-dropdown').val();
        var naturalezasSinPersonas = [61, 92];
        
        $('.supervisor-wrapper').each(function() {
            var wrapper = $(this);
            wrapper.find('input').val('');
            wrapper.find('.tabla-datos').addClass('d-none');
            wrapper.find('.origen-data, .help-block').text('').removeClass('text-danger text-success');

            if (naturalezaId == 2 || naturalezaId == 19 || naturalezaId == 79) {
                wrapper.find('.busqueda-supervisor').removeClass('d-none');
                wrapper.find('.supervisor-manual').addClass('d-none');
            } else if (naturalezaId == 31 || naturalezaId == 35) {
                wrapper.find('.busqueda-supervisor').addClass('d-none');
                wrapper.find('.supervisor-manual').removeClass('d-none');
            } else {
                wrapper.find('.busqueda-supervisor, .supervisor-manual').addClass('d-none');
            }
        });

        if (naturalezaId && !naturalezasSinPersonas.includes(parseInt(naturalezaId))) {
            $('#agregar-persona, #sub-container').removeClass('d-none');
        } else {
            $('#agregar-persona, #sub-container').addClass('d-none');
        }
    });
    ",
    View::POS_READY,
    'validacion-supervisor'
);

?>