<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Estatus;
use app\models\Gerencia;
use app\models\AuthRbac;
use yii\web\View;
use yii\helpers\Url;


/** @var yii\web\View $this */
/** @var app\models\Usuarios $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="usuarios-form">

<?php $form = ActiveForm::begin(); ?>
        <br>
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
                        <th scope="col" class="tit-cedula">Cedula</th>
                        <th scope="col" class="tit-nombre">Nombre</th>
                        <th scope="col" class="tit-apellido">Apellido</th>
                        <th scope="col" class="tit-gerencia">Gerencia</th>
                        <th scope="col" class="tit-cargo">Cargo</th>
                        <th scope="col" class="tit-correo">Correo</th>

                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="cedula"></td>
                        <td class="nombre"></td>
                        <td class="apellido"></td>
                        <td class="gerencia"></td>
                        <td class="cargo"></td>
                        <td class="correo"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <?= $form->field($model, 'username')->textInput(['placeholder'=>'Ejemplo: A1234567']) ?>

    <?= $form->field($model, 'password')->passwordInput(['placeholder'=>'escriba su contraseña']) ?>

    <?= $form->field($model, 'name', [
        'template' => "<div>{input}\n{error}</div>",
    ])->checkboxList(ArrayHelper::map(Yii::$app->authManager->getRoles(),'name','name'), [
        'itemOptions' => [
            'labelOptions' => ['class' => 'custom-control-label w-100 my-1'],
            'wrapperOptions' => ['class'=>'form-check'],
        ],
    ]) ?>

    <?= $form->field($model, 'id_estatus')->dropDownList(
    ArrayHelper::map(Estatus::find()->all(),'id_estatus','descripcion'),
    ['prompt'=> 'seleccionar status']);?>
  


    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    

</div>

<?php
    $this->registerJs(
                
        //Validando cedula

        "

            // Verificar si estamos en modo edición (ajusta según tu lógica)
            // var isUpdateMode = $('#ci').val() !== '';

            // if (isUpdateMode) {
            // $('#searchCedula').hide();
            // $('#boton-validar-cedula').hide();
            // }

            $('#boton-validar-cedula').on('click', function(e) {
                e.preventDefault();

                // Obtener la cédula a validar
                var search = $('#searchCedula').val();
                
                alert('Datos: '+search);


                // Mostrar mensaje de espera
                $('p strong#origen-data')
                .removeClass('text-success text-danger text-info')
                .addClass('text-secondary')
                .text('Espere...');

                // Ocultar/mostrar tabla de resultados
                $('div.container-resp-ajax div.tabla-datos').addClass('d-none');


                $('#usuarios-ci').val('');


                $.ajax({
                    url: '".Url::toRoute('usuarios/validar-cedula')."',
                    type: 'post',
                    dataType: 'json',
                    data: {search: search}
                })
                .done(function(response) {
                    console.log(response);

                            $('p strong#origen-data').removeClass('text-secondary text-info text-danger').addClass('text-success').text('Datos encontrados en Personal.');
                            $('div.container-resp-ajax div.tabla-datos').removeClass('d-none');
                            $('div.container-resp-ajax div.tabla-datos table thead tr th.d-none').removeClass('d-none');
                            $('div.container-resp-ajax div.tabla-datos table tbody tr td.d-none').removeClass('d-none');

                            $('div.container-resp-ajax div.tabla-datos table tbody tr td.cedula').text(response.ci);
                            $('div.container-resp-ajax div.tabla-datos table tbody tr td.nombre').text(response.nombre);
                            $('div.container-resp-ajax div.tabla-datos table tbody tr td.apellido').text(response.apellido);
                            $('div.container-resp-ajax div.tabla-datos table tbody tr td.gerencia').text(response.gerencia);
                            $('div.container-resp-ajax div.tabla-datos table tbody tr td.cargo').text(response.cargo);
                            $('div.container-resp-ajax div.tabla-datos table tbody tr td.correo').text(response.correo);


                            //$('#persona-icedula').val(response.cedula);
                            


                })


                .fail(function() {
                    console.log('error al enviar el ajax');
                });


            });
        ", //codigo  js en linea

        View::POS_READY, //ubicacion de ejecucion
        'validacion_cedula' //id del js
    );

    $this->registerJs(
            
        //Inhabilitar boton en caso de que esté vacío el campo cédula

        "

            $( '#boton-validar-cedula' ).attr( 'disabled', true );

            $('#searchCedula').on('input', function(e){
                if ($('#searchCedula').val() != '' || $('#searchCedula').val() != null){
                    $( '#boton-validar-cedula' ).attr( 'disabled', false );
                } else {
                    $( '#boton-validar-cedula' ).attr( 'disabled', true );
                }
            });


        ", //codigo  js en linea

        View::POS_READY, //ubicacion de ejecucion
        'inhabilitar_boton_validar' //id del js
    );



?>

