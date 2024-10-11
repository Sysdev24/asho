<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;


/** @var yii\web\View $this */
/** @var app\models\AfecPerCategoria $model */

$this->title = $model->name;
\yii\web\YiiAsset::register($this);
?>
<div class="afec-per-categoria-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <br>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            //'parent_id',
            'name',
            //'complete_name',
            //'parent_path',
            'codigo',
            //'created_at',
            //'update_at',
            'id_estatus',
        ],
    ]) ?>

    <!-- BOTON DE VOLVER-->
    <?= Html::button('Atrás', ['class' => 'my-custom-button', 'onclick' => 'location.href=\''.Url::toRoute(["index"]).'\'']) ?>

</div>
