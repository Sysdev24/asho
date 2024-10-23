<?php

use app\models\Usuarios;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use app\models\Estatus;
use app\models\Personal;


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
                'attribute' => 'ci',
                'label' => 'Cedula',
                'contentOptions' => ['style' => 'width:15%; text-align: center; vertical-align: middle;'], // Cambia el tamaño de la columna
                'filterInputOptions' => [
                    'class' => 'form-control',
                    'placeholder' => 'Busqueda',
                ],
            ],

            [   
                'attribute' => 'username',
                'label' => 'Usuario',
                'contentOptions' => ['style' => 'width:15%; text-align: center; vertical-align: middle;'], // Cambia el tamaño de la columna
                'filterInputOptions' => [
                    'class' => 'form-control',
                    'placeholder' => 'Busqueda',
                ],
            ],


            [
                'attribute' => 'personal.nombre',
                'label' => 'Nombre',
                'contentOptions' => ['style' => 'width:15%; text-align: center; vertical-align: middle;'], // Cambia el tamaño de la columna
                'value' => array($searchModel, 'buscarNombre'),
                'filter' => Html::activeTextInput($searchModel, 'nombre', [
                    'class' => 'form-control',
                    'placeholder' => 'Buscar nombre',
                ]),
            ],

            [
                'attribute' => 'personal.apellido',
                'contentOptions' => ['style' => 'width:15%; text-align: center; vertical-align: middle;'], // Cambia el tamaño de la columna
                'value' => array($searchModel, 'buscarApellido'),
                'filter' => 
                Html::activeTextInput($searchModel, 'apellido', [
                    'class' => 'form-control',
                    'placeholder' => 'Buscar apellido',
                ]),
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
