<?php

use app\models\PeligroAgente;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\PeligroagenteSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Peligro Agente';
?>
<div class="peligro-agente-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Crear Peligro Agente', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pager' => [
            'options' => ['class'=> 'pagination'],
            'firstPageCssClass' => 'page-item',
            'lastPageCssClass' => 'page-item', 
            'nextPageCssClass' => 'page-item',
            'prevPageCssClass' => 'page-item',
            'pageCssClass' => 'page-item',
            'disabledPageCssClass' => 'disabled d-none',
            'linkOptions' => ['style' => 'text-decoration: none;', 'class' => 'page-link'],
        ],
        'columns' => [

            ['class' => 'yii\grid\SerialColumn',
            'header' => 'Nº'], //Para que no aparezca el # sino la letra que se requiera


            //'id_pel_agen',
            //'id_sub2_clas_pel',
            //'id_sub_cla_pel',
            //'id_cla_pel',
            //'id_peligro',
            //'descripcion',
            [   
                'attribute' => 'descripcion',
                'label' => 'Descripcion',
                'filterInputOptions' => [
                    'class' => 'form-control',
                    'placeholder' => 'Busqueda',
                ]
            ],
            //'codigo',
            [   
                'attribute' => 'codigo',
                'label' => 'Codigo',
                'filterInputOptions' => [
                    'class' => 'form-control',
                    'placeholder' => 'Busqueda',
                ]
            ],
            //'created_at',
            //'updated_at',
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

            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, PeligroAgente $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id_pel_agen' => $model->id_pel_agen]);
                 }
            ],
        ],
    ]); ?>


</div>
