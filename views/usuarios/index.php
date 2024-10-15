<?php

use app\models\Usuarios;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use app\models\Estatus;

/** @var yii\web\View $this */
/** @var app\models\UsuariosSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Usuario';
?>
<div class="usuarios-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Crear Usuarios', ['create'], ['class' => 'btn btn-success']) ?>
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
                'attribute' => 'personal.nacionalidad',
                'label' => 'Nombre',
                'filterInputOptions' => [
                    'class' => 'form-control',
                    'placeholder' => 'Busqueda',
                ],
            ],
            [   
                'attribute' => 'ci',
                'label' => 'Cedula',
                'filterInputOptions' => [
                    'class' => 'form-control',
                    'placeholder' => 'Busqueda',
                ],
            ],

            [   
                'attribute' => 'username',
                'label' => 'Usuario',
                'filterInputOptions' => [
                    'class' => 'form-control',
                    'placeholder' => 'Busqueda',
                ],
            ],

            [
                'attribute' => 'personal.nombre',
                'label' => 'Nombre',
                'filterInputOptions' => [
                    'class' => 'form-control',
                    'placeholder' => 'Busqueda',
                ],
            ],

            [   
                'attribute' => 'personal.apellido',
                'label' => 'Apellido',
                'filterInputOptions' => [
                    'class' => 'form-control',
                    'placeholder' => 'Busqueda',
                ],
            ],

           /* [
                'attribute' => 'roles.name',
                'label' => 'Rol',
                'filterInputOptions' => [
                    'class' => 'form-control',
                    'placeholder' => 'Busqueda',
                ],
            ],*/

             //Esto es Para que muestre el estatus en vez del id almacenado en la tabla regiones
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
                'attribute' => 'personal.gerencia.descripcion',
                'label' => 'Gerencia',
                'filterInputOptions' => [
                    'class' => 'form-control',
                    'placeholder' => 'Busqueda',
                ],
            ],

           /* [   
                'attribute' => 'name',
                'label' => 'Roles',
                'filterInputOptions' => [
                    'class' => 'form-control',
                    'placeholder' => 'Busqueda',
                ],
                
                'value' => function($model){
                    //return   $model->name->name;
                    return   isset($model->name->descripcion) ? $model->name->name : 'N/D';
                },
                    //return   isset($model->gerencia->descripcion) ? $model->gerencia->descripcion : 'N/D';

            ],*/

            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Usuarios $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id_usuario' => $model->id_usuario]);
                 }
            ],
        ],
    ]); ?>


</div>
