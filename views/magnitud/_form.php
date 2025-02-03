<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Estatus;

/** @var yii\web\View $this */
/** @var app\models\Magnitud $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="magnitud-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'descripcion')->textInput(['placeholder'=>'Escriba nombre de la magnitud']) ?>

    <?= $form->field($model, 'codigo')->textInput() /** GENERA AUTOMATICAMENTE*/?>

    <!-- Este if es para que lo que está dentro de él unicamente aparezca en actualizar -->
    <?php if (!$model->isNewRecord): ?>
    <?= $form->field($model, 'id_estatus')->dropDownList(
        ArrayHelper::map(
            Estatus::find()
                ->where(['in', 'descripcion', ['ACTIVO', 'INACTIVO']])
                ->all(),
            'id_estatus',
            'descripcion'
        ),
        ['prompt' => 'seleccionar status']
    ); ?>
    <?php endif; ?>


    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
