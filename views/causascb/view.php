<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\CausasCb $model */

$this->title = $model->id_causas_cb;
$this->params['breadcrumbs'][] = ['label' => 'Causas Cbs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="causas-cb-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id_causas_cb' => $model->id_causas_cb], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id_causas_cb' => $model->id_causas_cb], [
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
            'id_causas_cb',
            'id_sub2_fac',
            'id_sub_fac',
            'id_cau_fac_bas_raiz',
            'id_cau_bas_raiz',
            'descripcion',
            'created_at',
            'updated_at',
            'id_estatus',
        ],
    ]) ?>

</div>
