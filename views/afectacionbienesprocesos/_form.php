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
    <?= $form->field($model, 'afectacion')->textInput() ?>

 
    <?= $form->field($model, 'id_estatus')->dropDownList(ArrayHelper::map(Estatus::find()->all(),'id_estatus','descripcion'),['prompt'=> 'seleccionar status']);?>


    <?= $form->field($model, 'valor')->textInput() ?>


    <div class="form-group">
    <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
