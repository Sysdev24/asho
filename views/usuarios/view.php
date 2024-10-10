<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\Usuarios $model */

$this->title = $model->username;

\yii\web\YiiAsset::register($this);
?>
<div class="usuarios-view">

    <h1><?= Html::encode($this->title) ?></h1>

  <br>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [

            'ci',
            'username',
            
            'nombre',
            'apellido',
            'email:email',
            
             [   
                'attribute' => 'id_gerencia',
                'label' => 'Gerencia',
                'value' => function($model){
                    return   $model->gerencia->descripcion;},
            ],
           
            [   
                'attribute' => 'id_estatus',
                'label' => 'Estatus',
                'value' => function($model){
                    return   $model->estatus->descripcion;},
            ],

            'name',

        ],
    ]) ?>

 <!-- BOTON DE VOLVER-->
 <?= Html::button('Atrás', ['class' => 'my-custom-button', 'onclick' => 'location.href=\''.Url::toRoute(["index"]).'\'']) ?>
    

</div>
