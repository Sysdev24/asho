<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\AfectacionPersona $model */

$this->title = $model->id_area_afectada;
$this->params['breadcrumbs'][] = ['label' => 'Afectacion Personas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="afectacion-persona-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id_area_afectada' => $model->id_area_afectada], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id_area_afectada' => $model->id_area_afectada], [
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
            'id_area_afectada',
            'id_sub_area_afect',
            'id_sub2_area_afect',
            'descripcion',
            'codigo',
            'created_at',
            'updated_at',
            'id_estatus',
        ],
    ]) ?>

</div>
