<?php

use app\models\PeligroAgente;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\PeligroagenteSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Peligro Agentes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="peligro-agente-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Peligro Agente', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_pel_agen',
            'id_sub2_clas_pel',
            'id_sub_cla_pel',
            'id_cla_pel',
            'id_peligro',
            //'descripcion',
            //'codigo',
            //'created_at',
            //'updated_at',
            //'id_estatus',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, PeligroAgente $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id_pel_agen' => $model->id_pel_agen]);
                 }
            ],
        ],
    ]); ?>


</div>
