<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\TipoTrabajo $model */

$this->title = $model->id_tipo_trabajo;
$this->params['breadcrumbs'][] = ['label' => 'Tipo Trabajos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="tipo-trabajo-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id_tipo_trabajo' => $model->id_tipo_trabajo], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id_tipo_trabajo' => $model->id_tipo_trabajo], [
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
            'id_tipo_trabajo',
            'descripcion',
            'created_at',
            'updated_at',
            'id_estatus',
            'codigo',
        ],
    ]) ?>

</div>
