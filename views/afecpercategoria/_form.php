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

    <?= $form->field($model, 'parent_id')->dropDownList(
    ArrayHelper::map(AfecPerCategoria::find()->where(['parent_id' => null])->all(), 'id', 'name'),
    ['prompt' => 'Seleccionar']
    ) ?>

    <?= $form->field($model, 'name')->textInput(['id' => 'name', 'disabled' => true]) ?>

    <?= $form->field($model, 'id_estatus')->dropDownList
    (ArrayHelper::map(Estatus::find()->all(),'id_estatus','descripcion'),
    ['prompt'=> 'seleccionar status']);?>

    <script>
    $(document).ready(function() {
        $('#parent_id').change(function() {
            var parentId = $(this).val();
            var parentPath = $('#parent_path').val(); // Suponiendo que tienes un campo oculto para parent_path
            $('#nuevo-nombre').prop('disabled', !(parentId === null && (parentPath === '1/' || parentPath === '2/')));
        });
    });
    </script>


    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
