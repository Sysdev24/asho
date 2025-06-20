<?php

use app\models\Estados;
use app\models\Registro;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var app\models\RegistroSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Registros';
?>
<div class="registro-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Crear Registro', ['create'], ['class' => 'btn btn-success']) ?>
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
            [
                'class' => 'yii\grid\SerialColumn',
            'header' => 'Nº', //Para que no aparezca el # sino la letra que se requiera],
            'contentOptions' => ['style' => 'text-align: center; vertical-align: middle;'], // Cambia el tamaño de la columna
            ],
                        
            [   
                'attribute' => 'cedula_reporta',
                'label' => 'Cédula Reporta',
                'filterInputOptions' => [
                    'class' => 'form-control',
                    'placeholder' => 'Busqueda',
                ],
                'contentOptions' => ['style' => 'width:13%; text-align: center; vertical-align: middle;'], // Cambia el tamaño de la columna
            ],

            [   
                'attribute' => 'nro_accidente',
                'label' => 'Nro Accidente',
                'filterInputOptions' => [
                    'class' => 'form-control',
                    'placeholder' => 'Busqueda',
                ],
                'contentOptions' => ['style' => 'width:16%; text-align: center; vertical-align: middle;'], // Cambia el tamaño de la columna
            ],

            [
                'attribute' => 'cedula_pers_accide',
                'label' => 'C.I. Accidentado',
                'value' => function($model) {
                    // Verifica si la cédula está seteada, si no, devuelve 'N/A'
                    // Aquí asumimos que un valor de 1 en la base de datos indica 'N/A'
                    if (is_null($model->cedula_pers_accide) || $model->cedula_pers_accide == 1) {
                        return 'N/A';
                    }
                    return $model->cedula_pers_accide;
                },
                'contentOptions' => ['style' => 'width:13%; text-align: center; vertical-align: middle;'], // Cambia el tamaño de la columna
                'filterInputOptions' => ['class' => 'form-control', 'placeholder' => 'Busqueda'],
            ],

            [
                'attribute' => 'nombre',
                'label' => 'Nombre',
                'value' => function($model) {
                    if (!empty($model->personaNaturals)) {
                        return $model->personaNaturals[0]->nombre; // Accede al primer elemento
                    } elseif ($model->cedulaPersAccide) {
                        return $model->cedulaPersAccide->nombre;
                    }
                    return 'Nombre no disponible';
                },
                'contentOptions' => ['style' => 'width:13%; text-align: center; vertical-align: middle;'], // Cambia el tamaño de la columna
                'filter' => Html::activeTextInput($searchModel, 'nombre', [
                'class' => 'form-control',
                'placeholder' => 'Busqueda'
            ]),
            ],

            [
                'attribute' => 'apellido',
                'label' => 'Apellido',
                'value' => function($model) {
                    if (!empty($model->personaNaturals)) {
                        return $model->personaNaturals[0]->apellido; // Accede al primer elemento
                    } elseif ($model->cedulaPersAccide) {
                        return $model->cedulaPersAccide->apellido;
                    }
                    return 'Apellido no disponible';
                },
                'contentOptions' => ['style' => 'width:13%; text-align: center; vertical-align: middle;'], // Cambia el tamaño de la columna
                'filter' => Html::activeTextInput($searchModel, 'apellido', [
                'class' => 'form-control',
                'placeholder' => 'Busqueda'
            ]),
            ],

            [
                'attribute' => 'id_estado',
                'value' => array($searchModel, 'buscarEstados'),
                'contentOptions' => ['style' => 'width:16%; text-align: center; vertical-align: middle;'], // Cambia el tamaño de la columna
                'filter' => Html::activeTextInput($searchModel, 'descripcion', [
                'class' => 'form-control',
                'placeholder' => 'Busqueda',
                ]),

            ],

            [   
                'attribute' => 'id_estatus_proceso',
                'label' => 'Estatus',
                'filterInputOptions' => [
                    'class' => 'form-control',
                    'placeholder' => 'Busqueda',
                ],
                'value' => function($model){
                    return   $model->estatusProceso->descripcion;},
                'contentOptions' => ['style' => 'width:16%; text-align: center; vertical-align: middle;'], // Cambia el tamaño de la columna
            ],
         
            
            [
                'class' => ActionColumn::className(),
                //'hiddenFromExport' => true,
                'contentOptions' => ['class'=>'text-center align-middle', 'style'=>'min-width:110px;'],
                'template' => '{view}{update}',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        $url = ['view', 'id_registro'=>$model->id_registro];
                        $link = Html::a('<i class="fas fa-eye me-1"></i>', $url, [
                            'title' => Yii::t('yii', 'View'),
                            'aria-label' => Yii::t('yii', 'View'),
                            'data-pjax' => '0',
                            'class' => 'me-1',
                        ]);
                        return \Yii::$app->user->can('registro/index') ? $link : '';
                    },
                    'update' => function ($url, $model, $key) {
                        $url = ['update', 'id_registro'=>$model->id_registro];
                        $link = Html::a('<i class="fas fa-edit me-1"></i>', $url, [
                            'title' => Yii::t('yii', 'Update'),
                            'aria-label' => Yii::t('yii', 'Update'),
                            'data-pjax' => '0',
                            'class' => 'me-1',
                        ]);
                        return  \Yii::$app->user->can('registro/update') ? $link : '';
                    },
                ],
            ], 
        ],
    ]); ?>


</div>
