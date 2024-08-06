<?php

use app\models\AfectacionBienesProcesos;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\AfectacionbienesprocesosSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'AFECTACION BIENES Y PROCESOS';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="afectacion-bienes-procesos-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Crear Afectacion Bienes Procesos', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn',
        'header' => 'Nº'], //Para que no aparezca el # sino la letra que se requiera],

            //'id_afec_bien_pro',
            'afectacion',
            'valor',
            //'created_at',
            //'updated_at',
            //'id_estatus',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, AfectacionBienesProcesos $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id_afec_bien_pro' => $model->id_afec_bien_pro]);
                 }
            ],
        ],
    ]); ?>


</div>
