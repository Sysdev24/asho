<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\ClasificacionAccidente $model */

$this->title = $model->id_clasif_accid_lab_ope_amb;
$this->params['breadcrumbs'][] = ['label' => 'Clasificacion Accidentes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="clasificacion-accidente-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id_clasif_accid_lab_ope_amb' => $model->id_clasif_accid_lab_ope_amb], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id_clasif_accid_lab_ope_amb' => $model->id_clasif_accid_lab_ope_amb], [
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
            'id_clasif_accid_lab_ope_amb',
            'descripcion',
            'codigo',
            //'id_estatus',
            [   
                'attribute' => 'id_estatus',
                'label' => 'Estatus',
                'value' => function($model){
                    return   $model->estatus->descripcion;},
            ],
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
