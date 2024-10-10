<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\ReglaOro $model */

$this->title = $model->descripcion;

\yii\web\YiiAsset::register($this);
?>
<div class="regla-oro-view">

    <h1><?= Html::encode($this->title) ?></h1>

 <br>

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
