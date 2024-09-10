<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Roles $model */

$this->title = $model->description;

\yii\web\YiiAsset::register($this);
?>
<div class="roles-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->name], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->name], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Estas seguro que desea eliminar?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'description',
        ],
    ]) ?>

    <?= Html::a(
        '<i class="fas fa-reply me-1"></i> ' . Yii::t('app', 'Atrás'),
        Yii::$app->request->referrer, ['class'=>'btn btn-secondary mt-3']
    ) ?>

</div>
