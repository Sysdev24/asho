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
    
    // Validación para personal
    $(document).on('click', '.boton-validar-supervisor', function() {
        var wrapper = $(this).closest('.supervisor-wrapper');
        var search = wrapper.find('input[id^=\"searchCedulaSup_\"]').val();
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