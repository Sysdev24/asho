<?php

use app\models\Estados;
use app\models\Estatus;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;


/** @var yii\web\View $this */
/** @var app\models\EstadosSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Estado';
?>
<div class="estados-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <!-- <p>
        <?= Html::a('Crear Estado', ['create'], ['class' => 'btn btn-success', ]) ?>
    </p> -->

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
                'attribute' => 'descripcion',
                'label' => 'Descripcion',
                'filterInputOptions' => [
                    'class' => 'form-control',
                    'placeholder' => 'Busqueda',
                ]
            ],

            //Esto es Para que muestre el estatus en vez del id almacenado en la tabla regiones
            [   
            'attribute' => 'id_estatus',
            'value' => array($searchModel, 'buscarEstatus'),
            'filter' => Html::activeDropDownList($searchModel, 'id_estatus', [
            'Activo' => 'ACTIVO',
            'Inactivo' => 'INACTIVO',], 
            ['prompt' => 'Busqueda', 'class' => 'form-control']),
            'headerOptions' => ['class' => 'col-lg-03 text-center'],
            'contentOptions' => ['class' => 'col-lg-03 text-center'],
            ],

            // [
            //     'class' => ActionColumn::className(),
            //     'urlCreator' => function ($action, Estados $model, $key, $index, $column) {
            //         return Url::toRoute([$action, 'id_estado' => $model->id_estado]);
            //      }
            // ],
        ],
    ]); ?>


</div>
