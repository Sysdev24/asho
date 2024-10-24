<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Estatus;
use app\models\AfecPerCategoria;
use yii\helpers\Url;


/** @var yii\web\View $this */
/** @var app\models\AfecPerCategoria $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="afec-per-categoria-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <div class="row">

    <?= $form->field($model, 'parent_id', [
        'inputOptions' => ['placeholder' => $model->getAttributeLabel('parent_id')]
    ])->dropdownList(\app\models\AfecPerCategoria::getProductCategoryParentArrayList($model->id), [
        'prompt' => Yii::t('app', 'Select...'),
        'class' => 'custom-select',
    ]) ?>

    <?= $form->field($model, 'name', [
        'inputOptions'=>['placeholder'=>$model->getAttributeLabel('name')]
    ])->textInput(['maxlength' => true]) ?>

</div>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_estatus')->dropDownList
    (ArrayHelper::map(Estatus::find()->all(),'id_estatus','descripcion'),
    ['prompt'=> 'seleccionar status']);?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
