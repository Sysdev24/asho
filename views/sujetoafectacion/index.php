<?php

use app\models\SujetoAfectacion;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\SujetoAfectacionSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Sujeto Afectacions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sujeto-afectacion-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Sujeto Afectacion', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_sujeto_afect',
            'id_clasif_con_afect',
            'id_con_afectacion',
            'id_afectacion',
            'descripcion',
            //'codigo',
            //'id_estatus',
            //'created_at',
            //'updated_at',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, SujetoAfectacion $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id_sujeto_afect' => $model->id_sujeto_afect]);
                 }
            ],
        ],
    ]); ?>


</div>
