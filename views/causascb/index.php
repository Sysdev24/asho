<?php

use app\models\CausasCb;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\CausascbSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Causas Cbs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="causas-cb-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Causas Cb', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_causas_cb',
            'id_sub2_fac',
            'id_sub_fac',
            'id_cau_fac_bas_raiz',
            'id_cau_bas_raiz',
            //'descripcion',
            //'created_at',
            //'updated_at',
            //'id_estatus',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, CausasCb $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id_causas_cb' => $model->id_causas_cb]);
                 }
            ],
        ],
    ]); ?>


</div>
