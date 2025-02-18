<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\Estatus $model */

$this->title = $model->descripcion;

\yii\web\YiiAsset::register($this);
?>
<div class="estatus-view">

    <br>
        <h3><?= Html::encode($this->title) ?></h3>
    <br>


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'siglas',
            'descripcion',
        
        ],
    ]) ?>

     <!-- BOTON DE VOLVER-->
     <?= Html::button('Atrás', ['class' => 'my-custom-button', 'onclick' => 'location.href=\''.Url::toRoute(["index"]).'\'']) ?>
    

</div>
