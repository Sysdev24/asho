<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\NaturalezaAccidente $model */

$this->title = $model->descripcion;
$this->params['breadcrumbs'][] = ['label' => 'Naturaleza Accidentes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="naturaleza-accidente-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['update', 'id_naturaleza_accidente' => $model->id_naturaleza_accidente], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id_naturaleza_accidente' => $model->id_naturaleza_accidente], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
           // 'id_naturaleza_accidente',
            'descripcion',
            'codigo',
            //'created_at',
            //'updated_at',
            //'id_estatus',
            [   
                'attribute' => 'id_estatus',
                'label' => 'Estatus',
                'value' => function($model){
                    return   $model->estatus->descripcion;},
            ],
        ],
    ]) ?>

</div>
