<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\PeligroAgente $model */

$this->title = $model->id_pel_agen;
$this->params['breadcrumbs'][] = ['label' => 'Peligro Agentes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="peligro-agente-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id_pel_agen' => $model->id_pel_agen], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id_pel_agen' => $model->id_pel_agen], [
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
            'id_pel_agen',
            'id_sub2_clas_pel',
            'id_sub_cla_pel',
            'id_cla_pel',
            'id_peligro',
            'descripcion',
            'codigo',
            'created_at',
            'updated_at',
            'id_estatus',
        ],
    ]) ?>

</div>
