<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Estatus;

/** @var yii\web\View $this */
/** @var app\models\Gerencia $model */
/** @var yii\widgets\ActiveForm $form */
?>
    <!-- Aquí se asegura de mostrar los mensajes flash --> 
<div class="gerencia-form">
<div
    class="gerencia-index">
    <?php if (Yii::$app->session->hasFlash('error')): ?>
    <div class="alert alert-danger"> 
    <?= Yii::$app->session->getFlash('error') ?> 
    </div> <?php endif; ?> 

    
</div>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'descripcion')->textInput(['placeholder'=>'Escriba nombre de la gerencia']) ?>

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



    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
