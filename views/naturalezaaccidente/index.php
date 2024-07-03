<?php

use app\models\NaturalezaAccidente;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\NaturalezaaccidenteSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Naturaleza Accidentes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="naturaleza-accidente-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Crear Naturaleza Accidente', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn',
            'header' => 'Nº'],

            //'id_naturaleza_accidente',
            //'descripcion',
            [   
                'attribute' => 'descripcion',
                'label' => 'Descripcion',
                'filterInputOptions' => [
                    'class' => 'form-control',
                    'placeholder' => 'Busqueda',
                ]
            ],
           // 'codigo',
            [   
                'attribute' => 'codigo',
                'label' => 'Codigo',
                'filterInputOptions' => [
                    'class' => 'form-control',
                    'placeholder' => 'Busqueda',
                ]
            ],
            //'created_at',
            //'updated_at',
            //'id_estatus',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, NaturalezaAccidente $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id_naturaleza_accidente' => $model->id_naturaleza_accidente]);
                 }
            ],
        ],
    ]); ?>


</div>
