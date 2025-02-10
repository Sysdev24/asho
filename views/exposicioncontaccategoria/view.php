<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\grid\ActionColumn;



/** @var yii\web\View $this */
/** @var app\models\ExposicionContacCategoria $model */

$this->title = $model->name;

\yii\web\YiiAsset::register($this);
?>
<div class="exposicion-contac-categoria-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <br>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            //'parent_id',
            'name',
            //'complete_name',
            //'parent_path',
            'codigo',
            [   
                'attribute' => 'id_estatus',
                'label' => 'Estatus',
                'value' => function($model){
                    return   $model->estatus->descripcion;},
            ],
            //'created_at',
            //'updated_at',
        ],
    ]) ?>

<br>
    <?php if ($model->getChildren()->count() > 0): ?>
        <h2>Hijos</h2>  <?= GridView::widget([
            'dataProvider' => new \yii\data\ActiveDataProvider([
                'query' => $model->getChildren(),
                'pagination' => [
                    'pageSize' => 10,
                ],
            ]),
            'pager' => [
                'options' => ['class' => 'pagination'],
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
                'header' => 'Nº',
                'contentOptions' => ['style' => 'text-align: center; vertical-align: middle;']],

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
                    'attribute' => 'codigo',
                    'label' => 'Codigo',
                    'contentOptions' => ['style' => 'width:40%; text-align: center; vertical-align: middle;'], // Cambia el tamaño de la columna
                    'filterInputOptions' => [
                        'class' => 'form-control',
                        'placeholder' => 'Busqueda',
                    ],                    
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view}', // Solo mostrar el botón "view"
                    'buttons' => [
                        'view' => function ($url, $model, $key) {
                            $url = ['view', 'id' => $model->id];
                            $link = Html::a('<i class="fas fa-eye me-1"></i>', $url, [
                                'title' => Yii::t('yii', 'View'),
                                'aria-label' => Yii::t('yii', 'View'),
                                'data-pjax' => '0',
                                'class' => 'me-1',
                            ]);
                            return \Yii::$app->user->can('exposicioncontaccategoria/index') ? $link : '';
                        },
                    ],
                ],
            ],
        ]); ?>
    <?php else: ?>
    <?php endif; ?>

    <!-- BOTON DE VOLVER-->
    <?= Html::button('Atrás', ['class' => 'my-custom-button', 'onclick' => 'window.history.back();'])?>

</div>
