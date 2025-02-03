<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Estatus;

/** @var yii\web\View $this */
/** @var app\models\CausasCb $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="causas-cb-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_sub2_fac')->textInput() ?>

    <?= $form->field($model, 'id_sub_fac')->textInput() ?>

    <?= $form->field($model, 'id_cau_fac_bas_raiz')->textInput() ?>

    <?= $form->field($model, 'id_cau_bas_raiz')->textInput() ?>

    <?= $form->field($model, 'descripcion')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

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
