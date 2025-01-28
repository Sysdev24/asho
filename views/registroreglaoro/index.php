<?php

use app\models\RegistroReglaOro;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\RegistroreglaoroSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Registro de Regla de Oro';
?>
<div class="registro-regla-oro-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Crear Registro de Regla de Oro', ['create'], ['class' => 'btn btn-success']) ?>
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


            //'id_registro_regla_oro',
            //'id_nro_accidente:boolean',

            //'id_opcion1:boolean',
            [   
                'attribute' => 'id_opcion1',
                'label' => 'Opcion 1',
                'filterInputOptions' => [
                    'class' => 'form-control',
                    'placeholder' => 'Busqueda',
                ],
                
                'value' => function($model){
                    return   $model->id_opcion1->descripcion;},
            ],
            //'id_opcion2:boolean',
            [   
                'attribute' => 'id_opcion2',
                'label' => 'Opcion 2',
                'filterInputOptions' => [
                    'class' => 'form-control',
                    'placeholder' => 'Busqueda',
                ],
                
                'value' => function($model){
                    return   $model->id_opcion2->descripcion;},
            ],
            //'id_opcion3:boolean',
            [   
                'attribute' => 'id_opcion3',
                'label' => 'Opcion 3',
                'filterInputOptions' => [
                    'class' => 'form-control',
                    'placeholder' => 'Busqueda',
                ],
                
                'value' => function($model){
                    return   $model->id_opcion3->descripcion;},
            ],
           // 'id_opcion4:boolean',
            [   
                'attribute' => 'id_opcion4',
                'label' => 'Opcion 4',
                'filterInputOptions' => [
                    'class' => 'form-control',
                    'placeholder' => 'Busqueda',
                ],
                
                'value' => function($model){
                    return   $model->id_opcion4->descripcion;},
            ],
            //'id_opcion_5:boolean',
            [   
                'attribute' => 'id_opcion_5',
                'label' => 'Opcion 5',
                'filterInputOptions' => [
                    'class' => 'form-control',
                    'placeholder' => 'Busqueda',
                ],
                
                'value' => function($model){
                    return   $model->id_opcion5->descripcion;},
            ],
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
                //'hiddenFromExport' => true,
                'contentOptions' => ['class'=>'text-center align-middle', 'style'=>'min-width:110px;'],
                'template' => '{view}{update}{delete}',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        $url = ['view', 'id_registro_regla_oro'=>$model->id_registro_regla_oro];
                        $link = Html::a('<i class="fas fa-eye me-1"></i>', $url, [
                            'title' => Yii::t('yii', 'View'),
                            'aria-label' => Yii::t('yii', 'View'),
                            'data-pjax' => '0',
                            'class' => 'me-1',
                        ]);
                        return \Yii::$app->user->can('resgistroreglaoro/index') ? $link : '';
                    },
                    'update' => function ($url, $model, $key) {
                        $url = ['update', 'id_registro_regla_oro'=>$model->id_registro_regla_oro];
                        $link = Html::a('<i class="fas fa-edit me-1"></i>', $url, [
                            'title' => Yii::t('yii', 'Update'),
                            'aria-label' => Yii::t('yii', 'Update'),
                            'data-pjax' => '0',
                            'class' => 'me-1',
                        ]);
                        return  \Yii::$app->user->can('resgistroreglaoro/update') ? $link : '';
                    },
                    'delete' => function ($url, $model, $key) {
                        $url = ['delete', 'id_registro_regla_oro'=>$model->id_registro_regla_oro];
                        $link = Html::a('<i class="fas fa-trash-alt me-2"></i>', $url, [
                            'title' => Yii::t('yii', 'Delete'),
                            'aria-label' => Yii::t('yii', 'Delete'),
                            'data-pjax' => '0',
                            'class' => 'mx-0',
                            'data' => [
                                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                                'method' => 'post',
                            ],
                        ]);
                        return \Yii::$app->user->can('resgistroreglaoro/delete') ? $link : '';
                    },
                ],
            ],
           
           
            // [
            //     'class' => ActionColumn::className(),
            //     'urlCreator' => function ($action, RegistroReglaOro $model, $key, $index, $column) {
            //         return Url::toRoute([$action, 'id_registro_regla_oro' => $model->id_registro_regla_oro]);
            //      }
            // ],
        ],
    ]); ?>


</div>
