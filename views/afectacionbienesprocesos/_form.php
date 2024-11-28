<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Estatus;

/** @var yii\web\View $this */
/** @var app\models\AfectacionBienesProcesos $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="afectacion-bienes-procesos-form">

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'afectacion')->textInput(['placeholder'=>'Ejemplo: 0=']) ?>

 
    <?= $form->field($model, 'id_estatus')->dropDownList(
    ArrayHelper::map(
        Estatus::find()
            ->where(['in', 'descripcion', ['ACTIVO', 'INACTIVO']])
            ->all(),
        'id_estatus',
        'descripcion'
    ),
    ['prompt'=> 'seleccionar status']
    );?>


    <?= $form->field($model, 'valor')->textInput(['placeholder'=>'Grado de afectación']) ?>


    <div class="form-group">
    <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
