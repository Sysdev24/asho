<?php

use app\models\CausaInmediataDirectas;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\CausainmediatadirectasSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Causa Inmediata Directas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="causa-inmediata-directas-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Causa Inmediata Directas', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_cau_inm_dir',
            'id_sub2_caus_inm_dir',
            'id_sub1_caus_inm_dir',
            'descripcion',
            'created_at',
            //'updated_at',
            //'id_estatus',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, CausaInmediataDirectas $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id_cau_inm_dir' => $model->id_cau_inm_dir]);
                 }
            ],
        ],
    ]); ?>


</div>
