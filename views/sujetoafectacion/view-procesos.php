<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\SujetoAfectacion $model */

$this->title = $model->descripcion;

\yii\web\YiiAsset::register($this);
?>
<div class="sujeto-afectacion-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['update-procesos', 'id_sujeto_afect' => $model->id_sujeto_afect], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete-procesos', 'id_sujeto_afect' => $model->id_sujeto_afect], [
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
           // 'id_sujeto_afect',
            //'id_clasif_con_afect',
            //'id_con_afectacion',
            //'id_afectacion',
            'descripcion',
            'codigo',
            //'id_estatus',
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

  <!-- BOTON DE VOLVER-->
  <?= Html::button('Atrás', ['class' => 'my-custom-button', 'onclick' => 'location.href=\''.Url::toRoute(["personas"]).'\'']) ?>
    

</div>
