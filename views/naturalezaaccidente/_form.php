<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Estatus;
use app\models\NaturalezaAccidente;

/** @var yii\web\View $this */
/** @var app\models\NaturalezaAccidente $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="naturaleza-accidente-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'descripcion')->textInput() ?>

    <?= $form->field($model, 'codigo')->textInput() ?>


    <?= $form->field($model, 'id_estatus')->dropDownList(
        ArrayHelper::map(Estatus::find()->all(), 'id_estatus', 'descripcion'),
        [
            'prompt' => 'Selecciona el estatus',
        ]);
    ?>




    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
