<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;


/** @var yii\web\View $this */
/** @var app\models\Estados $model */

$this->title = $model->descripcion;

\yii\web\YiiAsset::register($this);
?>
<div class="estados-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['update', 'id_estado' => $model->id_estado], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id_estado' => $model->id_estado], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Estas seguro que desea eliminar?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id_estado',
            'descripcion',

            [   
                'attribute' => 'id_estatus',
                'label' => 'Estatus',
                'value' => function($model){
                    return   $model->estatus->descripcion;},
            ],

            //'created_at',
            //'updated_at',
           
            [   
                'attribute' => 'id_regiones',
                'label' => 'Regiones',
                'value' => function($model){
                    return   $model->regiones->descripcion;},
            ],
        ],
    ]) ?>

      <!-- BOTON DE VOLVER-->
      <?= Html::button('Atrás', ['class' => 'my-custom-button', 'onclick' => 'location.href=\''.Url::toRoute(["index"]).'\'']) ?>


</div>
