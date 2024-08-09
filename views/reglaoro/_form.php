<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Estatus;

/** @var yii\web\View $this */
/** @var app\models\ReglaOro $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="regla-oro-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'descripcion')->textInput() ?>

    <?= $form->field($model, 'estatus')->dropDownList(
        ArrayHelper::map(Estatus::find()->all(),'id_estatus','descripcion'),
        ['prompt'=> 'seleccionar status']);?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
