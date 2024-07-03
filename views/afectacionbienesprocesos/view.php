<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\AfectacionBienesProcesos $model */

$this->title = $model->id_afec_bien_pro;
$this->params['breadcrumbs'][] = ['label' => 'Afectacion Bienes Procesos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="afectacion-bienes-procesos-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id_afec_bien_pro' => $model->id_afec_bien_pro], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id_afec_bien_pro' => $model->id_afec_bien_pro], [
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
            'id_afec_bien_pro',
            'afectacion',
            'valor',
            'created_at',
            'updated_at',
            'id_estatus',
        ],
    ]) ?>

</div>
