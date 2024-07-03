<?php

use app\models\ClasificacionIncidente;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\ClasificacionincidenteSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Clasificacion Incidentes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clasificacion-incidente-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Clasificacion Incidente', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_clasif_accid_lab_ope_amb',
            'descripcion',
            'codigo',
            'id_estatus',
            'created_at',
            //'updated_at',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, ClasificacionIncidente $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id_clasif_accid_lab_ope_amb' => $model->id_clasif_accid_lab_ope_amb]);
                 }
            ],
        ],
    ]); ?>


</div>
