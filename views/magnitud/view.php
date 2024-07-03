<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Magnitud $model */

$this->title = $model->id_magnitud;
$this->params['breadcrumbs'][] = ['label' => 'Magnituds', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="magnitud-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id_magnitud' => $model->id_magnitud], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id_magnitud' => $model->id_magnitud], [
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
            'id_magnitud',
            'descripcion',
            'codigo',
            'id_estatus',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
