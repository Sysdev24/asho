<?php

use app\models\RegistroReglaOro;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\RegistroreglaoroSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Registro Regla Oros';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="registro-regla-oro-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Crear Registro Regla Oro', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            ['class' => 'yii\grid\SerialColumn',
            'header' => 'Nº'], //Para que no aparezca el # sino la letra que se requiera


            //'id_registro_regla_oro',
            //'id_nro_accidente:boolean',
            //'id_opcion1:boolean',
            //'id_opcion2:boolean',
            //'id_opcion3:boolean',
            //'id_opcion4:boolean',
            //'id_opcion_5:boolean',
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
                'urlCreator' => function ($action, RegistroReglaOro $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id_registro_regla_oro' => $model->id_registro_regla_oro]);
                 }
            ],
        ],
    ]); ?>


</div>
