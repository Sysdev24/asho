<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\AfectacionBienesProcesos $model */

$this->title = $model->valor;

\yii\web\YiiAsset::register($this);
?>
<div class="afectacion-bienes-procesos-view">

    <h1><?= Html::encode($this->title) ?></h1>

<br>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
    
            'afectacion',
            'valor',
          
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
