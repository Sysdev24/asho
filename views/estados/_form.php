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

    <?= $form->field($model, 'descripcion')->textInput()?>

 
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

        <?= $form->field($model, 'id_regiones')->dropDownList(
            ArrayHelper::map(Regiones::find()->all(),'id_regiones','descripcion'),
        ['prompt' => 'Selecciona la region',]);?>


        <div class="form-group">
            <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
        </div>

    <?php ActiveForm::end(); ?>

</div>
