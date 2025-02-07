<?php

use app\models\PersonaNatural;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\PersonanaturalSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Persona Natural';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="persona-natural-index">

    <h1><?= Html::encode($this->title) ?></h1>

    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'cedula',
            'nombre',
            'apellido',
            //'created_at',
            //'updated_at',
            'telefono',
            //'fecha_nac',
            //'id_registro',
            'empresa',
            //'id_estatus',
             
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, PersonaNatural $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
