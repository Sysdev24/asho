<?php

use app\models\Magnitud;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\MagnitudSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Magnituds';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="magnitud-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Magnitud', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_magnitud',
            'descripcion',
            'codigo',
            'id_estatus',
            'created_at',
            //'updated_at',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Magnitud $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id_magnitud' => $model->id_magnitud]);
                 }
            ],
        ],
    ]); ?>


</div>
