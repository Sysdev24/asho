<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Roles $model */

$this->title = $model->id_roles;
$this->params['breadcrumbs'][] = ['label' => 'Roles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="roles-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id_roles' => $model->id_roles], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id_roles' => $model->id_roles], [
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
            'id_roles',
            'descripcion',
            'guard_name',
            'id_estatus',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
