<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\Regiones $model */

$this->title = $model->descripcion;

\yii\web\YiiAsset::register($this);
?>
<div class="regiones-view">

    <br>
        <h3><?= Html::encode($this->title) ?></h3>
    <br>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id_regiones',
            'descripcion',
            
            [
                'attribute' => 'id_estatus',
                'label' => 'Estatus',
                'value' => function ($model) {
                    return $model->estatus ? $model->estatus->descripcion : 'N/A';
                },
            ],
            //'created_at',
            //'updated_at',
        ],
    ]) ?>

   <!-- BOTON DE VOLVER-->
   <?= Html::button('Atrás', ['class' => 'my-custom-button', 'onclick' => 'location.href=\''.Url::toRoute(["index"]).'\'']) ?>
    

</div>
