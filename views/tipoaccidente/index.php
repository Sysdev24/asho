<?php

use app\models\TipoAccidente;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\TipoaccidenteSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Tipo Accidentes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipo-accidente-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Tipo Accidente', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_tipo_accidente',
            'id_sub2_tipo_accid',
            'id_sub_tipo_accid',
            'id_tipo_accid1',
            'id_tipo_accid',
            //'descripcion',
            //'codigo',
            //'id_estatus',
            //'created_at',
            //'updated_at',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, TipoAccidente $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id_tipo_accidente' => $model->id_tipo_accidente]);
                 }
            ],
        ],
    ]); ?>


</div>
