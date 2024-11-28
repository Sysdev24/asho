<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Estatus;

/** @var yii\web\View $this */
/** @var app\models\SujeAfecCategoria $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="suje-afec-categoria-form">

<?php $form = ActiveForm::begin(); ?>
    <br>
    <div class="row">
        <div class="col-md-6">
        <?= $form->field($model, 'parent_id', [
        ])->dropdownList(\app\models\SujeAfecCategoria::getCategoryParentArrayList($model->id), [
            'prompt' => 'Seleccione', ]) ?>
        </div>

        <div class="col-md-6">
        <?= $form->field($model, 'name', [
        ])->textInput(['maxlength' => true]) ?>
        </div>
    </div>

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
