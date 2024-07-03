<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Gerencia $model */

$this->title = $model->id_gerencia;
$this->params['breadcrumbs'][] = ['label' => 'Gerencias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="gerencia-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id_gerencia' => $model->id_gerencia], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id_gerencia' => $model->id_gerencia], [
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
            'id_gerencia',
            'descripcion',
            'id_estatus',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
