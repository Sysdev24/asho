<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\ReglaOro $model */

$this->title = $model->descripcion;

\yii\web\YiiAsset::register($this);
?>
<div class="regla-oro-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['update', 'id_regla_oro' => $model->id_regla_oro], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id_regla_oro' => $model->id_regla_oro], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id_regla_oro',
            'descripcion',
            //'id_estatus',


            
            //'created_at',
            //'updated_at',
        ],
    ]) ?>

   <!-- BOTON DE VOLVER-->
   <?= Html::button('Atrás', ['class' => 'my-custom-button', 'onclick' => 'location.href=\''.Url::toRoute(["index"]).'\'']) ?>
    

</div>
