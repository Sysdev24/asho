<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Personal $model */

$this->title = $model->ci;
$this->params['breadcrumbs'][] = ['label' => 'Personals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="personal-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'ci' => $model->ci], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'ci' => $model->ci], [
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
            'ci',
            'nombre',
            'apellido',
            'nro_empleado',
            'id_gerencia',
            'id_estado',
            'id_estatus',
            'id_cargo',
            'created_at',
            'updated_at',
            'telefono',
            'fecha_nac',
            'id_registro',
        ],
    ]) ?>

</div>
