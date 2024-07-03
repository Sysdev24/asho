<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\SujetoAfectacion $model */

$this->title = $model->id_sujeto_afect;
$this->params['breadcrumbs'][] = ['label' => 'Sujeto Afectacions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="sujeto-afectacion-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id_sujeto_afect' => $model->id_sujeto_afect], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id_sujeto_afect' => $model->id_sujeto_afect], [
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
            'id_sujeto_afect',
            'id_clasif_con_afect',
            'id_con_afectacion',
            'id_afectacion',
            'descripcion',
            'codigo',
            'id_estatus',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
