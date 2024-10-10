<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\TipoTrabajo $model */

$this->title = $model->descripcion;

\yii\web\YiiAsset::register($this);
?>
<div class="tipo-trabajo-view">

    <h1><?= Html::encode($this->title) ?></h1>
<br>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id_tipo_trabajo',
            'descripcion',
            ///'created_at',
            //'updated_at',
            //'id_estatus',
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
