<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\TipAccCategoria;
use app\models\Estatus;


/** @var yii\web\View $this */
/** @var app\models\TipAccCategoria $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="peli-agen-categoria-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name', [
    ])->textInput(['maxlength' => true]) ?>

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