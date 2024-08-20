<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\EvaluacionPotencialPerdida $model */

$this->title = $model->descripcion;
$this->params['breadcrumbs'][] = ['label' => 'Evaluacion de Potencial y Perdidas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="evaluacion-potencial-perdida-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['update', 'id_eva_pot_per' => $model->id_eva_pot_per], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id_eva_pot_per' => $model->id_eva_pot_per], [
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
            //'id_eva_pot_per',
            'descripcion',
            //'created_at',
            //'updated_at',
            
            //'id_estatus',

            //Esto es Para que muestre el estatus en vez del id almacenado en la tabla estados
            [   
                'attribute' => 'id_estatus',
                'label' => 'Estatus',
                'filterInputOptions' => [
                'class' => 'form-control',
                'placeholder' => 'Busqueda',
                ],
     
                'value' => function($model){
                 return   $model->estatus->descripcion;},
         ],
        ],
    ]) ?>

</div>
