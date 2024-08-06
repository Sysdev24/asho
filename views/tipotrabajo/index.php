<?php

use app\models\TipoTrabajo;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\TipotrabajoSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'TIPO DE TRABAJOS';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipo-trabajo-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Crear Tipo Trabajo', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn',
        'header' => 'Nº'], //Para que no aparezca el # sino la letra que se requiera],

            //'id_tipo_trabajo',
            'descripcion',
            //'created_at',
            //'updated_at',
            //'id_estatus',
            'codigo',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, TipoTrabajo $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id_tipo_trabajo' => $model->id_tipo_trabajo]);
                 }
            ],
        ],
    ]); ?>


</div>
