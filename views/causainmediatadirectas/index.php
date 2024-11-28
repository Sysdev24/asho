<?php

use app\models\CausaInmediataDirectas;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use app\models\Estatus;

/** @var yii\web\View $this */
/** @var app\models\CausainmediatadirectasSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Causa Inmediata Directas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="causa-inmediata-directas-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <!-- <p>
        <?= Html::a('Create Causa Inmediata Directas', ['create'], ['class' => 'btn btn-success']) ?>
    </p> -->

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
            
            //Esto es Para que muestre el estatus en vez del id almacenado en la tabla regiones
            [   
                'attribute' => 'id_estatus',
                'value' => array($searchModel, 'buscarEstatus'),
                'filter' => 
                Html::activeDropDownList($searchModel, 'id_estatus',
                ArrayHelper::map(Estatus::find()
                ->where(['in', 'descripcion', ['ACTIVO', 'INACTIVO']])
                ->all(),
                'id_estatus',
                'descripcion'),
                ['prompt'=> 'Busqueda', 'class' => 'form-control']),
                'headerOptions' => ['class' => 'col-lg-03 text-center'],
                'contentOptions' => ['class' => 'col-lg-03 text-center'],
            ],

            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, CausaInmediataDirectas $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id_cau_inm_dir' => $model->id_cau_inm_dir]);
                 }
            ],
        ],
    ]); ?>


</div>
