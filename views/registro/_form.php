<?php

use app\models\Regiones;
use app\models\Gerencia;
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

    <?= $form->field($model, 'id_naturaleza_accidente')->dropDownList(
        ArrayHelper::map(NaturalezaAccidente::find()->where(['id_estatus' => 1])->all(), 'id_naturaleza_accidente', 'descripcion'),
        ['prompt' => 'Seleccionar Naturaleza de accidente', 'id' => 'naturaleza-dropdown']
    ) ?>

    <br>
    <h2>Sujeto de Afectación</h2>
    <br>

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
    ",
    View::POS_READY
);
?>