<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;


/** @var yii\web\View $this */
/** @var app\models\SujeAfecCategoria $model */

$this->title = $model->name;
\yii\web\YiiAsset::register($this);
?>
<div class="suje-afec-categoria-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <br>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            //'parent_id',
            'name',
            //'complete_name',
            //'parent_path',
            'codigo',
            [   
                'attribute' => 'id_estatus',
                'label' => 'Estatus',
                'value' => function($model){
                    return   $model->estatus->descripcion;},
            ],
            //'created_at',
            //'updated_at',
        ],
    ]) ?>

    <!-- BOTON DE VOLVER-->
    <?= Html::button('Atrás', ['class' => 'my-custom-button', 'onclick' => 'location.href=\''.Url::toRoute(["index"]).'\'']) ?>

</div>
