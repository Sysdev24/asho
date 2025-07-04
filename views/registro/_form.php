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

    <?php if ($model->scenario === 'primera'): ?>
    <h3>Quien reporta</h3>
    <?php endif; ?>

    <br>

    <?php
    // Obtener la cédula del usuario logeado
    $user = Yii::$app->user->identity;
    $cedulaReporta = $user->ci;

    // Asignar la cédula al modelo
    $model->cedula_reporta = $cedulaReporta;
    ?>

    <?php if ($model->scenario === 'primera'): ?>
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
            ['prompt' => 'Seleccionar estado', 'id' => 'estado-dropdown', 'disabled' => true,'required' => true]
        ); ?>
    <?php endif; ?>

    <?= $form->field($model, 'lugar')->textInput() ?>

    <?= $form->field($model, 'id_magnitud')->dropDownList(
        ArrayHelper::map(Magnitud::find()->all(), 'id_magnitud', 'descripcion'),
        ['prompt' => 'Seleccionar la Magnitud del accidente']
    ); ?>


    <?php if ($model->scenario === 'primera'): ?>
        <div id="naturalezas-adicionales">
            <?= $form->field($model, 'id_naturaleza_accidente')->dropDownList(
                ArrayHelper::map(NaturalezaAccidente::find()->where(['id_estatus' => 1])->all(), 'id_naturaleza_accidente', 'descripcion'),
                ['prompt' => 'Seleccionar Naturaleza de accidente', 'id' => 'naturaleza-dropdown']
            ) ?>
        </div>

        <!-- Botón para agregar naturaleza adicional (inicialmente visible) -->
        <button type="button" id="agregar-naturaleza" class="btn btn-success" style="margin-bottom: 15px;">
            <i class="fa fa-plus"></i> Agregar otra naturaleza
        </button>

    <?php endif; ?>


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
                                <input type="text" class="form-control" style="width: 150px;" id="searchCedula_0" name="searchCedula[]" pattern="[0-9]{8}" placeholder="Ej. 12345678" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
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

        
        <?php if ($model->scenario === 'primera'): ?>
        <div class="supervisor">
            <br>
            <br>
            <h3>Supervisor</h3>
            <br>
            <label for="searchCedulas" class="form-label">Cédula Supervisor</label>
            <div class="input-group mb-3 buscar-cedula">
                <input type="text" class="form-control" style="width: 150px;" id="searchCedulas" name="searchCedulas" pattern="[0-9]{8}" placeholder="Ej. 12345678" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                <button class="btn btn-primary" type="button" id="boton-validar-cedulas">Validar</button>
            </div> 

            <!-- Cambia estas clases a específicas para supervisor -->
            <div class="container-resp-ajax-supervisor">
                <p><strong class="origen-data-supervisor"></strong></p>
                <div class="tabla-datos-supervisor d-none">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th scope="col" class="tit-cedula">Cédula del supervisor</th>
                                <th scope="col" class="tit-nombre">Nombre</th>
                                <th scope="col" class="tit-apellido">Apellido</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="cedula-supervisor"></td>
                                <td class="nombre-supervisor"></td>
                                <td class="apellido-supervisor"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <?= $form->field($model, 'cedula_supervisor_60min')->hiddenInput(['id' => 'cedula_supervisor_60min'])->label(false) ?> <!-- Campo oculto para cédula -->
        </div>
        <br>
        <?php endif; ?>

    <?= $form->field($model, 'observaciones_60min')->textInput() ?>

    <?= $form->field($model, 'acciones_tomadas_60min')->textInput() ?>

    <?= $form->field($model, 'descripcion_accidente_60min')->textInput() ?>


    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
// Script principal, gestión de estructura
$this->registerJs(
    "
    $(document).ready(function() {

        $('#registro-fecha_hora').val(moment().format('DD-MM-YYYY HH:mm'));

        // Inicialización de variables
        var personaCounter = $('.persona-wrapper').length > 0 ? $('.persona-wrapper').length : 1;
        var naturalezaCount = 0;
        var maxNaturalezas = 1;

        // Función para actualizar atributos de elementos clonados
        function actualizarAtributos(elemento, nuevoIndex) {
            elemento.find('[id]').each(function() {
                var oldId = $(this).attr('id');
                if (oldId) {
                    $(this).attr('id', oldId.replace(/_\\d+$/, '_' + nuevoIndex));
                }
            });

            elemento.find('[name]').each(function() {
                var name = $(this).attr('name');
                if (name && name.match(/\\[\\d+\\]/)) {
                    $(this).attr('name', name.replace(/\\[\\d+\\]/, '[' + nuevoIndex + ']'));
                }
            });
        }

        // Manejo de personas
        // $('#agregar-persona').click(function() {
        //     var newIndex = personaCounter++;
        //     var newPersona = $('.persona-wrapper:first').clone();

        //     newPersona.attr('data-index', newIndex);
        //     newPersona.find('.card-title').text('Persona #' + (newIndex + 1));
        //     newPersona.find('.eliminar-persona').show();
        //     newPersona.find('input').val('');
        //     newPersona.find('.tabla-datos').addClass('d-none');
        //     newPersona.find('.origen-data').text('');

        //     actualizarAtributos(newPersona, newIndex);
        //     $('#personas-container').append(newPersona);

        //     if (personaCounter > 1) {
        //         $('.persona-wrapper:first .eliminar-persona').show();
        //     }
        // });

        // Manejo de personas afectadas
        $('#agregar-persona').click(function() {
            var newIndex = $('.persona-wrapper').length;
            var newPersona = $('.persona-wrapper:first').clone();
            
            // Limpiar campos nuevos
            newPersona.find('input').val('');
            newPersona.find('.tabla-datos').addClass('d-none');
            newPersona.find('.origen-data').text('');
            newPersona.find('.eliminar-persona').show();
            newPersona.find('.card-title').text('Persona #' + (newIndex + 1));
            
            // Actualizar atributos id y name con nuevo índice
            newPersona.find('[id]').each(function() {
                var oldId = $(this).attr('id');
                if (oldId) {
                    $(this).attr('id', oldId.replace(/\d+$/, newIndex));
                }
            });
            newPersona.find('[name]').each(function() {
                var name = $(this).attr('name');
                if (name && name.includes('[')) {
                    $(this).attr('name', name.replace(/$$(\d+)$$/, '[' + newIndex + ']'));
                }
            });

            $('#personas-container').append(newPersona);
            if ($('.persona-wrapper').length > 1) {
                $('.persona-wrapper .eliminar-persona').show();
            }
        });

        $(document).on('click', '.eliminar-persona', function() {
            if ($('.persona-wrapper').length > 1) {
                $(this).closest('.persona-wrapper').remove();
                personaCounter--;

                $('.persona-wrapper').each(function(i) {
                    $(this).attr('data-index', i);
                    $(this).find('.card-title').text('Persona #' + (i + 1));
                    actualizarAtributos($(this), i);
                });

                if ($('.persona-wrapper').length === 1) {
                    $('.persona-wrapper .eliminar-persona').hide();
                }
            }
        });

        // Manejo de naturalezas adicionales
        function actualizarOpcionesNaturalezas() {
            var seleccionPrincipal = $('#naturaleza-dropdown').val();
            var seleccionAdicional = $('#naturaleza-dropdown-adicional').val();
            
            $('#naturaleza-dropdown option').prop('disabled', false);
            if (seleccionAdicional) {
                $('#naturaleza-dropdown option[value=\"' + seleccionAdicional + '\"]').prop('disabled', true);
                if ($('#naturaleza-dropdown').val() == seleccionAdicional) {
                    $('#naturaleza-dropdown').val('');
                }
            }
            
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

        $('#agregar-naturaleza').click(function() {
            if (naturalezaCount < maxNaturalezas) {
                var nuevoId = 'naturaleza-adicional-' + Date.now();
                var nuevoDropdown = $('#naturaleza-dropdown').clone()
                    .attr('id', 'naturaleza-dropdown-adicional')
                    .attr('name', 'naturaleza_adicional')
                    .val('');
                
                var botonEliminar = $('<button>')
                    .attr('type', 'button')
                    .addClass('btn btn-danger btn-sm btn-eliminar-naturaleza')
                    .html('<i class=\"fa fa-trash\"></i>')
                    .css({'margin-left': '10px', 'vertical-align': 'middle'})
                    .click(function() {
                        $('#' + nuevoId).remove();
                        naturalezaCount--;
                        $('#agregar-naturaleza').show();
                        actualizarOpcionesNaturalezas();
                    });
                
                var contenedor = $('<div>')
                    .attr('id', nuevoId)
                    .addClass('naturaleza-adicional-container')
                    .css('margin-top', '15px')
                    .append(
                        $('<div>').addClass('form-group field-naturaleza-adicional').append(
                            $('<label>').addClass('control-label').text('Naturaleza Adicional'),
                            $('<div>').addClass('input-group').append(
                                nuevoDropdown,
                                $('<div>').addClass('input-group-append').append(botonEliminar)
                            )
                        )
                    );
                
                $('#naturalezas-adicionales').append(contenedor);
                naturalezaCount++;
                
                if (naturalezaCount >= maxNaturalezas) {
                    $(this).hide();
                } 
                
                actualizarOpcionesNaturalezas();
            }
        });

        // Manejo de regiones/estados
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
                        $('#estado-dropdown').append($('<option>', {
                            value: '',
                            text: 'Seleccionar estado'
                        }));
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

        // Inicialización
        $('#registro-fecha_hora').val(moment().format('DD-MM-YYYY HH:mm'));
        if ($('.persona-wrapper').length === 1) {
            $('.persona-wrapper .eliminar-persona').hide();
        }
        actualizarOpcionesNaturalezas();
    });
    ",
    View::POS_READY,
    'gestion-principal'
);

// Validación de Personas Afectadas
$this->registerJs(
    "
    $(document).ready(function() {
        // Función para verificar cédulas duplicadas
        function verificarCedulasDuplicadas() {
            var cedulas = [];
            var hayDuplicados = false;
            
            $('.busqueda-cedula input[type=\"text\"], .persona-natural input[id$=\"-cedula\"]').each(function() {
                var cedula = $(this).val();
                if (cedula && cedula.length >= 8) {
                    if (cedulas.includes(cedula)) {
                        hayDuplicados = true;
                        var errorContainer = $(this).closest('.form-group').find('.help-block').length ? 
                            $(this).closest('.form-group').find('.help-block') : 
                            $(this).closest('.persona-wrapper').find('.origen-data');
                        
                        errorContainer.removeClass('text-success')
                                     .addClass('text-danger')
                                     .text('Esta cédula ya está registrada en otra persona');
                    }
                    cedulas.push(cedula);
                }
            });
            
            return hayDuplicados;
        }

        // Validación para personal
        $(document).on('click', '.validar-cedula-btn', function() {
            var wrapper = $(this).closest('.persona-wrapper');
            var search = wrapper.find('input[id^=\"searchCedula_\"]').val();
            var naturalezaId = $('#naturaleza-dropdown').val();

            if (!/^[0-9]{8,}$/.test(search)) {
                wrapper.find('.origen-data').removeClass('text-success')
                                          .addClass('text-danger')
                                          .text('La cédula debe tener al menos 8 dígitos numéricos');
                return;
            }

            if (verificarCedulasDuplicadas()) {
                return;
            }

            if ([2, 19, 79].includes(parseInt(naturalezaId))) {
                $.ajax({
                    url: '".Url::to(['registro/validar-cedula'])."',
                    type: 'post',
                    dataType: 'json',
                    data: {search: search}
                })
                .done(function(response) {
                    if (verificarCedulasDuplicadas()) {
                        return;
                    }

                    if (!response.ci) {
                        wrapper.find('.origen-data').removeClass('text-success')
                                                  .addClass('text-danger')
                                                  .text('Cédula no encontrada en el sistema');
                        wrapper.find('.registro-cedula_pers_accide').val('');
                        return;
                    }

                    wrapper.find('.origen-data').removeClass('text-danger')
                                              .addClass('text-success')
                                              .text('Datos encontrados en Personal');
                    wrapper.find('.tabla-datos').removeClass('d-none');
                    
                    // Llenar campos con la respuesta
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
                        .text('Error al validar la cédula');
                });
            }
        });

        // Validación en tiempo real para cédulas
        $(document).on('change keyup', '.busqueda-cedula input, .persona-natural input[id$=\"-cedula\"]', function() {
            var currentCedula = $(this).val();
            
            if (currentCedula.length >= 8) {
                verificarCedulasDuplicadas();
            }
        });

        // Limpiar validación al vaciar campo
        $(document).on('change keyup', 'input[id^=searchCedula_]', function() {
            var wrapper = $(this).closest('.persona-wrapper');
            if ($(this).val().length === 0) {
                wrapper.find('.origen-data').text('').removeClass('text-danger text-success');
                wrapper.find('.tabla-datos').addClass('d-none');
                wrapper.find('.registro-cedula_pers_accide').val('');
            }
        });

        // Manejo de cambio en naturaleza de accidente
        $(document).on('change', '#naturaleza-dropdown, #naturaleza-dropdown-adicional', function() {
            var naturalezasSeleccionadas = [];
            var naturalezaPrincipal = Number($('#naturaleza-dropdown').val());
            var naturalezaAdicional = $('#naturaleza-dropdown-adicional').length ? 
                                Number($('#naturaleza-dropdown-adicional').val()) : null;
            
            if (naturalezaPrincipal) naturalezasSeleccionadas.push(naturalezaPrincipal);
            if (naturalezaAdicional) naturalezasSeleccionadas.push(naturalezaAdicional);
            
            var naturalezasSinPersonas = [61, 92];
            var sujetoAfectacionContainer = $('#sujeto-afectacion-container');
            var btnAgregarPersona = $('#agregar-persona');

            // Limpiar contenedores de secciones adicionales primero
            $('.seccion-adicional').remove();
            
            $('.persona-wrapper').each(function(index) {
                var wrapper = $(this);
                
                // Limpiar solo si no hay naturalezas seleccionadas
                if (naturalezasSeleccionadas.length === 0) {
                    wrapper.find('.busqueda-cedula input, .persona-natural input').val('');
                    wrapper.find('.origen-data').text('');
                    wrapper.find('.tabla-datos').addClass('d-none');
                    wrapper.find('.registro-cedula_pers_accide').val('');
                }

                // Deshabilitar solo si alguna naturaleza está en naturalezasSinPersonas
                var deshabilitar = naturalezasSeleccionadas.some(n => naturalezasSinPersonas.includes(n));
                wrapper.find('input, select, button').prop('disabled', deshabilitar);

                // Mostrar/ocultar card según si hay naturalezas que requieren personas
                var mostrarCard = !deshabilitar && naturalezasSeleccionadas.length > 0;
                wrapper.find('.card').toggleClass('d-none', !mostrarCard);

                // Determinar qué campos mostrar
                var mostrarBusqueda = naturalezasSeleccionadas.some(n => [2, 19, 79].includes(n));
                var mostrarNatural = naturalezasSeleccionadas.some(n => [31, 35].includes(n));
                
                // Si hay ambas naturalezas, crear una sección adicional para la segunda
                if (mostrarBusqueda && mostrarNatural && index === 0) {
                    // Clonar el wrapper original para la segunda sección
                    var nuevoWrapper = wrapper.clone();
                    nuevoWrapper.addClass('seccion-adicional');
                    nuevoWrapper.find('.card-title').text('Persona (Tercero)');
                    
                    // Modificar los campos en la nueva sección
                    nuevoWrapper.find('.busqueda-cedula').addClass('d-none');
                    nuevoWrapper.find('.persona-natural').removeClass('d-none');
                    
                    // Insertar después del wrapper original
                    wrapper.after(nuevoWrapper);
                    
                    // Modificar el wrapper original para mostrar solo búsqueda
                    wrapper.find('.card-title').text('Persona (Laboral)');
                    wrapper.find('.busqueda-cedula').removeClass('d-none');
                    wrapper.find('.persona-natural').addClass('d-none');
                } 
                else if (naturalezasSeleccionadas.length === 1) {
                    // Comportamiento normal para una sola naturaleza
                    wrapper.find('.busqueda-cedula').toggleClass('d-none', !mostrarBusqueda);
                    wrapper.find('.persona-natural').toggleClass('d-none', !mostrarNatural);
                    wrapper.find('.card-title').text('Persona #' + (index + 1));
                }
            });

            // Mostrar contenedor y botón si hay naturalezas que requieren personas
            var mostrarContenedores = !naturalezasSeleccionadas.some(n => naturalezasSinPersonas.includes(n)) && 
                                    naturalezasSeleccionadas.length > 0;
            btnAgregarPersona.toggleClass('d-none', !mostrarContenedores);
            sujetoAfectacionContainer.toggleClass('d-none', !mostrarContenedores);
        });
    });
    ",
    View::POS_READY,
    'validacion-personas'
);

//Validar cedula del supervisor
$this->registerJs(
    "
    $(document).ready(function() {
        // Función para verificar si debe mostrarse el supervisor
        function debeMostrarSupervisor() {
            var naturalezaId = $('#naturaleza-dropdown').val();
            var naturalezasConSupervisor = [2, 19, 79, 31, 35]; // IDs que permiten mostrar supervisor
            return naturalezaId && naturalezasConSupervisor.includes(parseInt(naturalezaId));
        }


        // Función para mostrar/ocultar el supervisor según la naturaleza
        function actualizarVisibilidadSupervisor() {
            if (debeMostrarSupervisor()) {
                $('.supervisor').removeClass('d-none');
            } else {
                $('.supervisor').addClass('d-none');
                // Limpiar campos al ocultar
                $('#searchCedulas').val('');
                ocultarDatosSupervisor();
                $('.origen-data-supervisor').text('').removeClass('text-danger text-success');
            }
        }

        // Función para mostrar mensajes del supervisor
        function mostrarMensajeSupervisor(mensaje, tipo) {
            if (!debeMostrarSupervisor()) return;
            
            var contenedor = $('.origen-data-supervisor');
            contenedor.removeClass('text-danger text-success text-info');
            
            if (tipo === 'error') {
                contenedor.addClass('text-danger');
            } else if (tipo === 'success') {
                contenedor.addClass('text-success');
            } else if (tipo === 'info') {
                contenedor.addClass('text-info');
            }
            
            contenedor.text(mensaje);
        }

        // Función para ocultar los datos del supervisor
        function ocultarDatosSupervisor() {
            $('.tabla-datos-supervisor').addClass('d-none');
            $('#cedula_supervisor_60min').val('');
            $('.origen-data-supervisor').text('').removeClass('text-danger text-success');
        }

        // Función para obtener todas las cédulas de personas afectadas
        function obtenerCedulasAfectadas() {
            if (!debeMostrarSupervisor()) return [];
            
            var cedulas = [];
            
            // Cédulas de empleados validados
            $('.cedula').not('.cedula-supervisor').each(function() {
                var cedula = $(this).text().trim();
                if (cedula.length >= 8) {
                    cedulas.push(cedula);
                }
            });
            
            // Cédulas en campos de búsqueda
            $('.busqueda-cedula input').each(function() {
                var cedula = $(this).val().trim();
                if (cedula.length >= 8) {
                    cedulas.push(cedula);
                }
            });
            
            // Cédulas de personas naturales
            $('.persona-natural input[id$=\"-cedula\"]').each(function() {
                var cedula = $(this).val().trim();
                if (cedula.length >= 8) {
                    cedulas.push(cedula);
                }
            });
            
            return [...new Set(cedulas)]; // Eliminar duplicados
        }

        // Variable para guardar la última cédula válida
        var ultimaCedulaValida = '';

        // Función principal de validación
        function validarSupervisor() {
            if (!debeMostrarSupervisor()) return true;
            
            var cedulaSupervisor = $('#searchCedulas').val().trim();
            
            // Ocultar datos si la cédula ha cambiado
            if (cedulaSupervisor !== ultimaCedulaValida) {
                ocultarDatosSupervisor();
            }
            
            if (cedulaSupervisor.length < 8) {
                return true; // No validar si la cédula es muy corta
            }
            
            var cedulasAfectadas = obtenerCedulasAfectadas();
            
            if (cedulasAfectadas.includes(cedulaSupervisor)) {
                mostrarMensajeSupervisor('El supervisor no puede ser la persona afectada', 'error');
                return false;
            }
            
            // Limpiar mensaje de error si ya no hay conflicto
            if ($('.origen-data-supervisor').text() === 'El supervisor no puede ser la persona afectada') {
                $('.origen-data-supervisor').text('').removeClass('text-danger');
            }
            
            return true;
        }

        // Validar al hacer clic en el botón
        $('#boton-validar-cedulas').on('click', function(e) {
            e.preventDefault();
            
            if (!debeMostrarSupervisor()) return;
            if (!validarSupervisor()) return;
            
            var search = $('#searchCedulas').val().trim();
            
            if (!/^[0-9]{8,}$/.test(search)) {
                mostrarMensajeSupervisor('La cédula debe tener al menos 8 dígitos', 'error');
                return;
            }
            
            mostrarMensajeSupervisor('Validando...', 'info');
            
            $.ajax({
                url: '".Url::to(['registro/validar-cedula'])."',
                type: 'post',
                dataType: 'json',
                data: {search: search}
            })
            .done(function(response) {
                if (!validarSupervisor()) return;
                
                if (!response.ci) {
                    mostrarMensajeSupervisor('Cédula no encontrada en el sistema', 'error');
                    return;
                }
                
                ultimaCedulaValida = response.ci;
                mostrarMensajeSupervisor('Datos encontrados en Personal', 'success');
                $('.tabla-datos-supervisor').removeClass('d-none');
                $('.cedula-supervisor').text(response.ci);
                $('.nombre-supervisor').text(response.nombre);
                $('.apellido-supervisor').text(response.apellido);
                $('#cedula_supervisor_60min').val(response.ci);
            })
            .fail(function() {
                mostrarMensajeSupervisor('Error al validar la cédula', 'error');
            });
        });

        // Ocultar datos cuando se modifica la cédula del supervisor
        $('#searchCedulas').on('input', function() {
            if (!debeMostrarSupervisor()) return;
            
            var currentCedula = $(this).val().trim();
            
            if (currentCedula !== ultimaCedulaValida || currentCedula.length === 0) {
                ocultarDatosSupervisor();
                ultimaCedulaValida = '';
            }
            
            $('#boton-validar-cedulas').prop('disabled', $(this).val().length < 8);
            validarSupervisor();
        });
        
        // Manejar cambio de naturaleza
        $(document).on('change', '#naturaleza-dropdown, #naturaleza-dropdown-adicional', function() {
            actualizarVisibilidadSupervisor();
            setTimeout(validarSupervisor, 300);
        });
        
        // Otros eventos
        $(document).on('change keyup', '.busqueda-cedula input, .persona-natural input[id$=\"-cedula\"]', function() {
            if ($('#searchCedulas').val().length >= 8) {
                validarSupervisor();
            }
        });
        
        $(document).on('click', '#agregar-persona', function() {
            setTimeout(validarSupervisor, 500);
        });
        
        // Inicialización
        actualizarVisibilidadSupervisor();
        $('#boton-validar-cedulas').prop('disabled', true);
    });
    ",
    View::POS_READY,
    'validacion-supervisor-mejorada'
);

?>