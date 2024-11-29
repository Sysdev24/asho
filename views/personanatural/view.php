<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\PersonaNatural $model */

$this->title = $model->ci;

\yii\web\YiiAsset::register($this);
?>
<div class="persona-natural-view">

    <h1><?= Html::encode($this->title) ?></h1>

<br>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'ci',
            'nombre',
            'apellido',
            'telefono',
            'fecha_nac',
            'id_registro',
            'empresa',
            [   
                'attribute' => 'id_estatus',
                'label' => 'Estatus',
                'value' => function($model){
                    return   $model->estatus->descripcion;},
            ],
        ],
    ]) ?>

</div>
