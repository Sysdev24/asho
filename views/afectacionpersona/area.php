<?php

use yii\grid\GridView;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use app\models\AfectacionPersona;
use yii\helpers\Html;
use app\widgets\CreateForm;
use yii\helpers\ArrayHelper;
use app\models\Estatus;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
    <div class="afectacion-persona-index">
    <h1>Area Afectada</h1>
    <p>
        <?= Html::a('Crear Area Afectada', ['create-area'], ['class' => 'btn btn-success']) ?>
    </p>
   

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
            'header' => 'Nº', //Para que no aparezca el # sino la letra que se requiera
            'contentOptions' => ['style' => 'text-align: center; vertical-align: middle;'], // Cambia el tamaño de la columna
            ], 
            [   
                'attribute' => 'descripcion',
                'label' => 'Descripcion',
                'contentOptions' => ['style' => 'width:30%; text-align: center; vertical-align: middle;'], // Cambia el tamaño de la columna
                'filterInputOptions' => [
                    'class' => 'form-control',
                    'placeholder' => 'Busqueda',
                ],
                
                
            ],
            [   
                'attribute' => 'codigo',
                'label' => 'Codigo',
                'contentOptions' => ['style' => 'width:15%; text-align: center; vertical-align: middle;'], // Cambia el tamaño de la columna
                'filterInputOptions' => [
                    'class' => 'form-control',
                    'placeholder' => 'Busqueda',
                ],
            ],
             //Esto es Para que muestre el estatus en vez del id almacenado en la tabla estados
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
                'urlCreator' => function ($action, AfectacionPersona $model, $key, $index, $column) {
                    if ($action === 'update') {
                        return Url::toRoute(['update-area', 'id' => $model->id_area_afectada]);
                    } elseif ($action === 'delete') {
                        return Url::toRoute(['delete-area', 'id' => $model->id_area_afectada]);
                    }
                    return Url::toRoute([$action, 'id_area_afectada' => $model->id_area_afectada]);
                }
            ],
        ],
    ]); ?>
</div>


