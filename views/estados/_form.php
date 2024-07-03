<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Estatus;
use app\models\Regiones;


/** @var yii\web\View $this */
/** @var app\models\Estados $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="estados-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'descripcion')->textInput() ?>

 
        <?= $form->field($model, 'id_estatus')->dropDownList(
        ArrayHelper::map(Estatus::find()->all(),'id_estatus','descripcion'),
        ['prompt'=> 'seleccionar status']);?>

        <?= $form->field($model, 'id_regiones')->dropDownList(
            ArrayHelper::map(Regiones::find()->all(),'id_regiones','descripcion'),
            ['prompt' => 'Selecciona la region',]);?>


    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
