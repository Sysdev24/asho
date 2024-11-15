<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Estatus;
use app\models\PeliAgenCategoria;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\PeliAgenCategoria $model */
/** @var yii\widgets\ActiveForm $form */

$this->title = 'Actualizar Peligro Agente Categoria: ' . $model->name;

?>

<div class="peli-agen-categoria-form">

    <?php $form = ActiveForm::begin(); ?>

    <!-- Ocultar los dropdowns de parent_id y child_id en la vista de actualización -->
    <?php if ($model->isNewRecord): ?>
        <?= $form->field($model, 'parent_id')->dropDownList(
            ArrayHelper::map(PeliAgenCategoria::find()->where(['parent_id' => null])->all(), 'id', 'name'),
            ['prompt' => 'Select Parent Item', 'id' => 'parent-id']
        ) ?>

        <?= $form->field($model, 'parent_id')->dropDownList(
            [],
            ['prompt' => 'Select Child Item', 'id' => 'child-id']
        ) ?>
    <?php endif; ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_estatus')->dropDownList(
        ArrayHelper::map(Estatus::find()->all(), 'id_estatus', 'descripcion'),
        ['prompt'=> 'seleccionar status']
    );?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => 'btn btn-success']) ?>
    </div>

    <!-- BOTON DE VOLVER-->
    <?= Html::button('Atrás', ['class' => 'my-custom-button', 'onclick' => 'location.href=\''.Url::toRoute(["index"]).'\'']) ?>

    <?php ActiveForm::end(); ?>

</div>

<?php if ($model->isNewRecord): ?>
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
    JS;
    $this->registerJs($script);
    ?>
<?php endif; ?>
