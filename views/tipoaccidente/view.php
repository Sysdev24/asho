<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\TipoAccidente $model */

$this->title = $model->id_tipo_accidente;
$this->params['breadcrumbs'][] = ['label' => 'Tipo Accidentes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="tipo-accidente-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id_tipo_accidente' => $model->id_tipo_accidente], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id_tipo_accidente' => $model->id_tipo_accidente], [
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
            'id_tipo_accidente',
            'id_sub2_tipo_accid',
            'id_sub_tipo_accid',
            'id_tipo_accid1',
            'id_tipo_accid',
            'descripcion',
            'codigo',
            'id_estatus',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
