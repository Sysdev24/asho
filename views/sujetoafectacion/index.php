<?php

use app\models\SujetoAfectacion;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\SujetoAfectacionSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'SUJETO DE AFECTACION';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sujeto-afectacion-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Crear Sujeto de Afectacion', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn',
        'header' => 'Nº'], //Para que no aparezca el # sino la letra que se requiera],

            //'id_sujeto_afect',
            //'id_clasif_con_afect',
            //'id_con_afectacion',
            //'id_afectacion',
            'descripcion',
            'codigo',
            //'id_estatus',
             //Esto es Para que muestre el estatus en vez del id almacenado en la tabla regiones
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
                'urlCreator' => function ($action, SujetoAfectacion $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id_sujeto_afect' => $model->id_sujeto_afect]);
                 }
            ],
        ],
    ]); ?>


</div>
