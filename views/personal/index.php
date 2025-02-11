<?php

use app\models\Personal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use app\models\Estatus;

/** @var yii\web\View $this */
/** @var app\models\PersonalSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Personal';
?>
<div class="personal-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Crear Personal', ['create'], ['class' => 'btn btn-success']) ?>
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
                'attribute' => 'nacionalidad',
                'label' => 'Nacionalidad',
                'contentOptions' => ['style' => 'width:5%; text-align: center; vertical-align: middle;'], // Cambia el tamaño de la columna
                'filterInputOptions' => [
                    'class' => 'form-control',
                    'placeholder' => 'Busqueda',
                ],
            ],
            [   
                'attribute' => 'ci',
                'label' => 'Cedula',
                'contentOptions' => ['style' => 'width:12%; text-align: center; vertical-align: middle;'], // Cambia el tamaño de la columna
                'filterInputOptions' => [
                    'class' => 'form-control',
                    'placeholder' => 'Busqueda',
                ],
            ],

            //'nombre',
            [   
                'attribute' => 'nombre',
                'label' => 'Nombre',
                'contentOptions' => ['style' => 'width:20%; text-align: center; vertical-align: middle;'], // Cambia el tamaño de la columna
                'filterInputOptions' => [
                    'class' => 'form-control',
                    'placeholder' => 'Busqueda',
                ],
            ],

            //'apellido',
            [   
                'attribute' => 'apellido',
                'label' => 'apellido',
                'contentOptions' => ['style' => 'width:20%; text-align: center; vertical-align: middle;'], // Cambia el tamaño de la columna
                'filterInputOptions' => [
                    'class' => 'form-control',
                    'placeholder' => 'Busqueda',
                ],
            ],
            
            //'nro_empleado',
            [   
                'attribute' => 'nro_empleado',
                'label' => 'Nro de empleado',
                'contentOptions' => ['style' => 'width:10%; text-align: center; vertical-align: middle;'], // Cambia el tamaño de la columna
                'filterInputOptions' => [
                    'class' => 'form-control',
                    'placeholder' => 'Busqueda',
                ],
            ],

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



            //'id_cargo',
            //'created_at',
            //'updated_at',
            //'telefono',
            //'fecha_nac',
            //'id_registro',
           
            [
                'class' => ActionColumn::className(),
                //'hiddenFromExport' => true,
                'contentOptions' => ['class'=>'text-center align-middle', 'style'=>'min-width:110px;'],
                'template' => '{view}{update}{toggle-status}',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        $url = ['view', 'ci'=>$model->ci];
                        $link = Html::a('<i class="fas fa-eye me-1"></i>', $url, [
                            'title' => Yii::t('yii', 'View'),
                            'aria-label' => Yii::t('yii', 'View'),
                            'data-pjax' => '0',
                            'class' => 'me-1',
                        ]);
                        return \Yii::$app->user->can('personal/index') ? $link : '';
                    },
                    'update' => function ($url, $model, $key) {
                        $url = ['update', 'ci'=>$model->ci];
                        $link = Html::a('<i class="fas fa-edit me-1"></i>', $url, [
                            'title' => Yii::t('yii', 'Update'),
                            'aria-label' => Yii::t('yii', 'Update'),
                            'data-pjax' => '0',
                            'class' => 'me-1',
                        ]);
                        return  \Yii::$app->user->can('personal/update') ? $link : '';
                    },
                    'toggle-status' => function ($url, $model, $key) {
                        if ($model->id_estatus == 1) {
                            $url = ['toggle-status', 'ci' => $model->ci];
                            $icon = '<i class="fa-solid fa-toggle-off"></i>';
                            $title = Yii::t('yii', 'Desactivar');
                            $confirmMessage = Yii::t('app', '¿Está seguro que desea desactivar este ítem?');
                        } else {
                            $url = ['toggle-status', 'ci' => $model->ci];
                            $icon = '<i class="fa-solid fa-toggle-on"></i>';
                            $title = Yii::t('yii', 'Activar');
                            $confirmMessage = Yii::t('app', '¿Está seguro que desea activar este ítem?');
                        }
                        $link = Html::a($icon, $url, [
                            'title' => $title,
                            'aria-label' => $title,
                            'data-pjax' => '0',
                            'class' => 'mx-0',
                            'data' => [
                                'confirm' => $confirmMessage,
                                'method' => 'post',
                            ],
                        ]);
                        return (\Yii::$app->user->can('personal/delete') || \Yii::$app->user->can('admin')) ? $link : '';
                    },
                ],
            ],     
           
           
            // [
            //     'class' => ActionColumn::className(),
            //     'urlCreator' => function ($action, Personal $model, $key, $index, $column) {
            //         return Url::toRoute([$action, 'ci' => $model->ci]);
            //     },
            //     'headerOptions' => ['class' => 'col-lg-1'], // Set header width to 10%
            //     'contentOptions' => ['class' => 'col-lg-1'], // Set content width to 10%
            // ],
            
        ],
    ]); ?>


</div>
