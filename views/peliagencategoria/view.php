<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;


/** @var yii\web\View $this */
/** @var app\models\PeliAgenCategoria $model */

$this->title = $model->name;
$this->params['breadcrumbs'] = $breadcrumbs;
\yii\web\YiiAsset::register($this);
?>
<div class="peli-agen-categoria-view">

    <br>
    <h3><?= Html::encode($this->title) ?></h3>

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
            //'created_at',
            //'update_at',
            [
                'attribute' => 'id_estatus',
                'label' => 'Estatus',
                'value' => function ($model) {
                    return $model->estatus ? $model->estatus->descripcion : 'N/A';
                },
            ],
        ],
    ]) ?>

<br>
    <?php if ($model->getChildren()->count() > 0): ?>
        <h3>CATEGORÍAS</h3>  <?= GridView::widget([
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
                            // Verificar si el modelo tiene hijos
                            if ($model->getChildren()->count() > 0) {
                                $url = ['view', 'id' => $model->id];
                                $link = Html::a('<i class="fas fa-eye me-1"></i>', $url, [
                                    'title' => Yii::t('yii', 'View'),
                                    'aria-label' => Yii::t('yii', 'View'),
                                    'data-pjax' => '0',
                                    'class' => 'me-1',
                                ]);
                                return \Yii::$app->user->can('peliagencategoria/index') ? $link : '';
                            }
                            return ''; // No mostrar el botón si no tiene hijos
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
