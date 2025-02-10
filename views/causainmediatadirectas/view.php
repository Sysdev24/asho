<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\CausaInmediataDirectas $model */

$this->title = $model->id_cau_inm_dir;
$this->params['breadcrumbs'][] = ['label' => 'Causa Inmediata Directas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="causa-inmediata-directas-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id_cau_inm_dir' => $model->id_cau_inm_dir], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id_cau_inm_dir' => $model->id_cau_inm_dir], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Está seguro que desea eliminar este ícono?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id_cau_inm_dir',
            'id_sub2_caus_inm_dir',
            'id_sub1_caus_inm_dir',
            'descripcion',
            'created_at',
            'updated_at',
            'id_estatus',
        ],
    ]) ?>

</div>
