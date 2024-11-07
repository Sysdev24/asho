<?php

use app\models\PeliAgenCategoria;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use app\models\Estatus;

/** @var yii\web\View $this */
/** @var app\models\PeliagencategoriaSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Peligro Agente Categorias';
?>
<div class="peli-agen-categoria-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Crear Peligro Agente Categoria', ['create'], ['class' => 'btn btn-success']) ?>
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
            'header' => 'Nº', //Para que no aparezca el # sino la letra que se requiera],
            'contentOptions' => ['style' => 'text-align: center; vertical-align: middle;'], // Cambia el tamaño de la columna
            ], 

            [   
                'attribute' => 'name',
                'label' => 'Nombre',
                'contentOptions' => ['style' => 'width:40%; text-align: center; vertical-align: middle;'], // Cambia el tamaño de la columna
                'filterInputOptions' => [
                    'class' => 'form-control',
                    'placeholder' => 'Busqueda',
                ],                    
            ],
            [   
                'attribute' => 'parent_path',
                'label' => 'Parebt',
                'contentOptions' => ['style' => 'width:20%; text-align: center; vertical-align: middle;'], // Cambia el tamaño de la columna
                'filterInputOptions' => [
                    'class' => 'form-control',
                    'placeholder' => 'Busqueda',
                ],                    
            ],

            [   
                'attribute' => 'codigo',
                'label' => 'Código',
                'contentOptions' => ['style' => 'width:15%; text-align: center; vertical-align: middle;'], // Cambia el tamaño de la columna
                'filterInputOptions' => [
                    'class' => 'form-control',
                    'placeholder' => 'Busqueda',
                ],                    
            ],
            
            [   
                'attribute' => 'id_estatus',
                'value' => array($searchModel, 'buscarEstatus'),
                'filter' => 
                Html::activeDropDownList($searchModel, 'id_estatus',
                ArrayHelper::map(Estatus::find()->all(), 'id_estatus', 'descripcion'),
                ['prompt'=> 'Busqueda', 'class' => 'form-control']),
                'headerOptions' => ['class' => 'col-lg-03 text-center'],
                'contentOptions' => ['class' => 'col-lg-03 text-center'],
            ],
            
            [
                'class' => ActionColumn::className(),
                'contentOptions' => ['style' => 'width: 10%; text-align: center; vertical-align: middle;'], // Cambia el tamaño de la columna
                'urlCreator' => function ($action, PeliAgenCategoria $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],

            
        ],
    ]); ?>


</div>
