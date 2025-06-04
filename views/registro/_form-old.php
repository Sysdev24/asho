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


    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>



</div>

<div id="sub-container" class="d-none">
    <br>
    <h3>Supervisor</h3>
    <br>
    </div>

<div id="supervisor-container">
    <div class="supervisor-wrapper">
        <div class="card mb-3 d-none">
            <div class="card-body">
                <div class="supervisor-buscar">
                    <div class="input-group mb-3 busqueda-supervisor d-none">
                        <input type="text" class="form-control" style="width: 150px;" id="searchCedulaSup" name="searchCedulaSup" pattern="[0-9]{8}" placeholder="Ingresar Cédula. Ej. 12345678" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                        <button class="btn btn-primary boton-validar-supervisor" type="button">
                                Validar
                            </button>
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
                                        <th scope="col" class="tit-empresa">Empresa</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="cedula"></td>
                                        <td class="nombre"></td>
                                        <td class="apellido"></td>
                                        <td class="telefono"></td>
                                        <td class="empresa"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?= $form->field($model, 'cedula_supervisor_60min')->hiddenInput()->label(false) ?> <!-- Campo oculto para cédula -->
                </div>

                <!-- Supervisor Manual -->
                <div class="supervisor-manual d-none">
                        <?= $form->field($modelPersonaNatural, "cedula")->textInput() ?>
                        <?= $form->field($modelPersonaNatural, "nombre")->textInput() ?>
                        <?= $form->field($modelPersonaNatural, "apellido")->textInput() ?>
                        <?= $form->field($modelPersonaNatural, "telefono")->textInput(['placeholder' => 'Ejemplo: 0412-1234567']) ?>
                        <?= $form->field($modelPersonaNatural, "empresa")->textInput() ?>
                    </div>
            </div>
        </div>
    </div>
</div>




<?php

$this->registerJs(
    "
    //Validar cedula del supervisor


    // Función para mostrar mensajes del supervisor
    function mostrarMensajeSupervisor(mensaje, clase) {
        $('.origen-data-supervisor')
            .removeClass('text-secondary text-success text-danger text-info')
            .addClass(clase)
            .text(mensaje);
    }

    // Función para mostrar datos del supervisor
    function mostrarDatosSupervisor(datos) {
        $('.tabla-datos-supervisor').removeClass('d-none');
        $('.cedula-supervisor').text(datos.ci);
        $('.nombre-supervisor').text(datos.nombre);
        $('.apellido-supervisor').text(datos.apellido);
        $('#registro-cedula_supervisor_60min').val(datos.ci);
    }

    // Función para ocultar datos del supervisor
    function ocultarDatosSupervisor() {
        $('.tabla-datos-supervisor').addClass('d-none');
        $('#registro-cedula_supervisor_60min').val('');
    }

    // Función mejorada para obtener cédulas de personas afectadas
    function obtenerCedulasAfectadas() {
        var cedulas = [];
        var naturalezaId = $('#naturaleza-dropdown').val();
        
        // Para LABORAL, NO LABORAL y TRANSITO (2, 19, 79)
        if ([2, 19, 79].includes(parseInt(naturalezaId))) {
            // 1. Cédulas validadas en busqueda-cedula
            $('.busqueda-cedula input[type=\"text\"]').each(function() {
                if ($(this).val() && $(this).val().length >= 8) {
                    cedulas.push($(this).val());
                }
            });
            
            // 2. Cédulas en campos ocultos
            $('input[name^=\"Registro[cedula_pers_accide]\"]').each(function() {
                if ($(this).val() && $(this).val().length >= 8) {
                    cedulas.push($(this).val());
                }
            });
        }
        // Para TERCEROS (31, 35)
        else if ([31, 35].includes(parseInt(naturalezaId))) {
            $('.persona-natural input[id$=\"-cedula\"]').each(function() {
                if ($(this).val() && $(this).val().length >= 8) {
                    cedulas.push($(this).val());
                }
            });
        }
        
        // 3. Cédulas mostradas en resultados (todas las naturalezas)
        $('.cedula:not(.cedula-supervisor)').each(function() {
            var cedula = $(this).text().trim();
            if (cedula && cedula.length >= 8) {
                cedulas.push(cedula);
            }
        });
        
        return [...new Set(cedulas)]; // Eliminar duplicados
    }

    // Función de validación principal mejorada
    function validarSupervisorNoEsAfectado(mostrarMensaje = true) {
        var cedulaSupervisor = $('#searchCedulas').val();
        if (!cedulaSupervisor || cedulaSupervisor.length < 8) return true;
        
        var cedulasAfectadas = obtenerCedulasAfectadas();
        var esDuplicada = cedulasAfectadas.includes(cedulaSupervisor);
        
        if (esDuplicada) {
            if (mostrarMensaje) {
                mostrarMensajeSupervisor('El supervisor no puede ser la persona afectada', 'text-danger');
            }
            ocultarDatosSupervisor();
            return false;
        }
        return true;
    }

    // Función para forzar la validación con mensaje
    function forzarValidacionSupervisor() {
        var search = $('#searchCedulas').val();
        if (search && search.length >= 8) {
            validarSupervisorNoEsAfectado(true);
        }
    }

    // Validación al hacer click en el botón
    $('#boton-validar-cedulas').on('click', function(e) {
        e.preventDefault();
        var search = $('#searchCedulas').val();

        if (!/^[0-9]{8,}$/.test(search)) {
            mostrarMensajeSupervisor('La cédula debe tener al menos 8 dígitos', 'text-danger');
            ocultarDatosSupervisor();
            return;
        }

        // Validar con mensaje
        if (!validarSupervisorNoEsAfectado(true)) return;

        mostrarMensajeSupervisor('Validando...', 'text-secondary');
        
        $.ajax({
            url: '" . Url::toRoute('registro/validar-cedula') . "',
            type: 'post',
            dataType: 'json',
            data: {search: search}
        })
        .done(function(response) {
            // Validar con mensaje
            if (!validarSupervisorNoEsAfectado(true)) return;
            
            if (!response.ci) {
                mostrarMensajeSupervisor('Cédula no encontrada', 'text-danger');
                ocultarDatosSupervisor();
            } else {
                mostrarMensajeSupervisor('Datos encontrados', 'text-success');
                mostrarDatosSupervisor(response);
            }
        })
        .fail(function() {
            mostrarMensajeSupervisor('Error en la validación', 'text-danger');
            ocultarDatosSupervisor();
        });
    });

    // Ocultar datos cuando cambia la cédula del supervisor
    $('#searchCedulas').on('change input', function() {
        if ($(this).val().length >= 8) {
            // Validar sin mostrar mensaje (para no mostrar el mensaje en cada tecla presionada)
            validarSupervisorNoEsAfectado(false);
        } else {
            ocultarDatosSupervisor();
            $('.origen-data-supervisor').text('').removeClass('text-danger text-success');
        }
    });

    // Eventos para validación en tiempo real (con mensaje cuando se agrega/modifica una persona afectada)
    $(document).on('change keyup', [
        '.busqueda-cedula input',
        'input[name^=\"Registro[cedula_pers_accide]\"]',
        '.persona-natural input[id$=\"-cedula\"]'
    ].join(','), function() {
        setTimeout(forzarValidacionSupervisor, 300); // Pequeño delay para asegurar que el valor esté actualizado
    });

    $(document).on('change', '#naturaleza-dropdown, #naturaleza-dropdown-adicional', function() {
        setTimeout(forzarValidacionSupervisor, 300);
    });

    $(document).on('click', '#agregar-persona', function() {
        setTimeout(forzarValidacionSupervisor, 500); // Mayor delay para permitir que se complete la adición
    });

    // Control del botón
    $('#boton-validar-cedulas').prop('disabled', true);
    $('#searchCedulas').on('input', function() {
        $('#boton-validar-cedulas').prop('disabled', $(this).val().length < 8);
        if ($(this).val().length >= 8) {
            validarSupervisorNoEsAfectado(false);
        }
    });
    ",
    View::POS_READY,
    'validacion-supervisor'
);



  

?>