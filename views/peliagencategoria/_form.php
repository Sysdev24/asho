<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Estatus;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use app\models\PeliAgenCategoria;

/** @var yii\web\View $this */
/** @var app\models\PeliAgenCategoria $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="peli-agen-categoria-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'parent_id')->dropDownList(
        ArrayHelper::map(PeliAgenCategoria::find()->where(['parent_id' => null])->all(), 'id', 'name'),
        ['prompt' => 'Select Parent Item', 'id' => 'parent-id']
    ) ?>

    <?= $form->field($model, 'name')->dropDownList(
        [],
        ['prompt' => 'Select Child Item', 'id' => 'child-id']
    ) ?>

    <?= $form->field($model, 'name')->dropDownList(
        [],
        ['prompt' => 'Select Grandchild Item', 'id' => 'grandchild-id']
    ) ?>

    <?= $form->field($model, 'name')->dropDownList(
        [],
        ['prompt' => 'Select Great-Grandchild Item', 'id' => 'greatgrandchild-id']
    ) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_estatus')->dropDownList(
        ArrayHelper::map(Estatus::find()->all(), 'id_estatus', 'descripcion'),
        ['prompt'=> 'seleccionar status']
    );?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$script = <<< JS
$('#parent-id').change(function() {
    var parentId = $(this).val();
    $.get('/peliagencategoria/get-items', { parent_id: parentId }, function(data) {
        var childSelect = $('#child-id');
        childSelect.empty();
        childSelect.append('<option>Select Child Item</option>');
        $.each(data.items, function(index, item) {
            childSelect.append('<option value="' + item.id + '">' + item.name + '</option>');
        });
    });
});

$('#child-id').change(function() {
    var childId = $(this).val();
    $.get('/peliagencategoria/get-items', { parent_id: childId }, function(data) {
        var grandchildSelect = $('#grandchild-id');
        grandchildSelect.empty();
        grandchildSelect.append('<option>Select Grandchild Item</option>');
        $.each(data.items, function(index, item) {
            grandchildSelect.append('<option value="' + item.id + '">' + item.name + '</option>');
        });
    });
});

$('#grandchild-id').change(function() {
    var grandchildId = $(this).val();
    $.get('/peliagencategoria/get-items', { parent_id: grandchildId }, function(data) {
        var greatgrandchildSelect = $('#greatgrandchild-id');
        greatgrandchildSelect.empty();
        greatgrandchildSelect.append('<option>Select Great-Grandchild Item</option>');
        $.each(data.items, function(index, item) {
            greatgrandchildSelect.append('<option value="' + item.id + '">' + item.name + '</option>');
        });
    });
});
JS;
$this->registerJs($script);
?>
