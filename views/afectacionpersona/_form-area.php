<?php

namespace app\models;

use yii\base\Model;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Estatus;


class SubAreaForm extends Model
{
    public $id_sub_area_afect;
    // ... otros atributos

    public function rules()
    {
        return [
            [['id_sub_area_afect'], 'required'],
            // ... otras reglas
        ];
    }
}
?>


<div class="afectacion-persona-form">

    <?php $form = ActiveForm::begin(['action' => ['create-area']]); ?>

    <?= $form->field($model, 'descripcion')->textInput() ?>

    <?= $form->field($model, 'codigo')->textInput() ?>

    <?= $form->field($model, 'id_estatus')->dropDownList(
    ArrayHelper::map(Estatus::find()->all(),'id_estatus','descripcion'),
    ['prompt'=> 'seleccionar status']);?>

    

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

