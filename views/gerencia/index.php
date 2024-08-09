<?php

use app\models\Gerencia;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\GerenciaSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'GERENCIA';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gerencia-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Crear Gerencia', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn',
        'header' => 'Nº'], //Para que no aparezca el # sino la letra que se requiera],

            //'id_gerencia',
            'descripcion',
            //'id_estatus',

            //Esto es Para que muestre el estatus en vez del id almacenado en la tabla estados
        [   
        'attribute' => 'id_estatus',
        'label' => 'Estatus',
        'filterInputOptions' => [
        'class' => 'form-control',
        'placeholder' => 'Busqueda',
        ],
    
    'value' => function($model){
        return   $model->estatus->descripcion;},
        ],


            //'created_at',
            //'updated_at',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Gerencia $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id_gerencia' => $model->id_gerencia]);
                 }
            ],
        ],
    ]); ?>


</div>
