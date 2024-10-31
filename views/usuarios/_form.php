<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Estatus;
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
    <?php if ($model->scenario === 'create'): ?>
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
    <?= $form->field($model, 'ci')->hiddenInput()->label(false) ?> <!-- Campo oculto para cédula -->
    <?php endif; ?>

    <?= $form->field($model, 'username')->textInput(['placeholder'=>'Ejemplo: A1234567']) ?>
    <?= $form->field($model, 'password')->passwordInput(['placeholder'=>'Escriba su contraseña']) ?>
    <?= $form->field($model, 'name', [
        'template' => "<div>{input}\n{error}</div>",
    ])->checkboxList(ArrayHelper::map(Yii::$app->authManager->getRoles(),'name','name'), [
        'itemOptions' => [
            'labelOptions' => ['class' => 'custom-control-label w-100 my-1'],
            'wrapperOptions' => ['class'=>'form-check'],
        ],
    ]) ?>
    <?= $form->field($model, 'id_estatus')->dropDownList(
        ArrayHelper::map(Estatus::find()->all(), 'id_estatus', 'descripcion'),
        ['prompt'=> 'Seleccionar estado']
    ); ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

<?php
// Registrar el script solo si el escenario es 'create'
if ($model->scenario === 'create') {
    $this->registerJs(
        "
        // Validando cédula
        $('#boton-validar-cedula').on('click', function(e) {
            e.preventDefault();
            // Obtener la cédula a validar
            var search = $('#searchCedula').val();
            alert('Datos: ' + search);
            // Mostrar mensaje de espera
            $('p strong#origen-data')
                .removeClass('text-success text-danger text-info')
                .addClass('text-secondary')
                .text('Espere...');
            // Ocultar/mostrar tabla de resultados
            $('div.container-resp-ajax div.tabla-datos').addClass('d-none');
            $('#usuarios-ci').val('');
            $.ajax({
                url: '" . Url::toRoute('usuarios/validar-cedula') . "',
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
                        .text('La cédula no se encuentra en el sistema. Regístrela primero en Personal.');
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
                $('div.container-resp-ajax div.tabla-datos table tbody tr td.gerencia').text(response.gerencia);
                $('div.container-resp-ajax div.tabla-datos table tbody tr td.cargo').text(response.cargo);
                $('div.container-resp-ajax div.tabla-datos table tbody tr td.correo').text(response.correo);
                // Llenar el campo oculto con la cédula
                $('#usuarios-ci').val(response.ci);
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
}
?>