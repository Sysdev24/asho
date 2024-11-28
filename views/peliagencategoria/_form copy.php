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
        ['prompt' => 'Seleccione', 'id' => 'parent-id']
    ) ?>

    <div id="child-container" style="display:none;">
        <?= $form->field($model, 'name')->dropDownList(
            [],
            ['prompt' => 'Seleccione', 'id' => 'child-id']
        ) ?>
        <button type="button" id="search-child" class="btn btn-primary">Buscar</button>
    </div>

    <div id="grandchild-container" style="display:none;">
        <?= $form->field($model, 'name')->dropDownList(
            [],
            ['prompt' => 'Seleccione', 'id' => 'grandchild-id']
        ) ?>
        <button type="button" id="search-grandchild" class="btn btn-primary">Buscar</button>
    </div>

    <div id="greatgrandchild-container" style="display:none;">
        <?= $form->field($model, 'name')->dropDownList(
            [],
            ['prompt' => 'Seleccione', 'id' => 'greatgrandchild-id']
        ) ?>
        <button type="button" id="search-greatgrandchild" class="btn btn-primary">Buscar</button>
    </div>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_estatus')->dropDownList(
        ArrayHelper::map(Estatus::find()->all(), 'id_estatus', 'descripcion'),
        ['prompt'=> 'Seleccionar status']
    );?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$script = <<< JS
$('#parent-id').change(function() {
    $('#child-container').show();
    var parentId = $(this).val();
    $.get('/peliagencategoria/get-items', { parent_id: parentId }, function(data) {
        var childSelect = $('#child-id');
        childSelect.empty();
        childSelect.append('<option>Seleccione</option>');
        $.each(data.items, function(index, item) {
            childSelect.append('<option value="' + item.id + '">' + item.name + '</option>');
        });
    });
});

$('#search-child').click(function() {
    $('#grandchild-container').show();
    var childId = $('#child-id').val();
    $.get('/peliagencategoria/get-items', { parent_id: childId }, function(data) {
        var grandchildSelect = $('#grandchild-id');
        grandchildSelect.empty();
        grandchildSelect.append('<option>Seleccione</option>');
        $.each(data.items, function(index, item) {
            grandchildSelect.append('<option value="' + item.id + '">' + item.name + '</option>');
        });
    });
});

$('#search-grandchild').click(function() {
    $('#greatgrandchild-container').show();
    var grandchildId = $('#grandchild-id').val();
    $.get('/peliagencategoria/get-items', { parent_id: grandchildId }, function(data) {
        var greatgrandchildSelect = $('#greatgrandchild-id');
        greatgrandchildSelect.empty();
        greatgrandchildSelect.append('<option>Seleccione</option>');
        $.each(data.items, function(index, item) {
            greatgrandchildSelect.append('<option value="' + item.id + '">' + item.name + '</option>');
        });
    });
});
JS;
$this->registerJs($script);
?>
