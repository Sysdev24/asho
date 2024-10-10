<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\NaturalezaAccidente $model */

$this->title = $model->descripcion;

\yii\web\YiiAsset::register($this);
?>
<div class="naturaleza-accidente-view">

    <h1><?= Html::encode($this->title) ?></h1>

<br>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'descripcion',
            'codigo',
           
            [   
                'attribute' => 'id_estatus',
                'label' => 'Estatus',
                'value' => function($model){
                    return   $model->estatus->descripcion;},
            ],
        ],
    ]) ?>

 <!-- BOTON DE VOLVER-->
 <?= Html::button('Atrás', ['class' => 'my-custom-button', 'onclick' => 'location.href=\''.Url::toRoute(["index"]).'\'']) ?>
    
</div>
