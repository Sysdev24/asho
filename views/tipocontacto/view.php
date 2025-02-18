<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\TipoContacto $model */

$this->title = $model->id_tipo_contacto;
\yii\web\YiiAsset::register($this);
?>
<div class="tipo-contacto-view">

    <br>
        <h3><?= Html::encode($this->title) ?></h3>
    <br>

    <p>
        <?= Html::a('Actualizar', ['update', 'id_tipo_contacto' => $model->id_tipo_contacto], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id_tipo_contacto' => $model->id_tipo_contacto], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Está seguro que desea eliminar este ícono?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id_tipo_contacto',
            'descripcion',

            [
                'attribute' => 'id_estatus',
                'label' => 'Estatus',
                'value' => function ($model) {
                    return $model->estatus ? $model->estatus->descripcion : 'N/A';
                },
            ],
        ],
    ]) ?>

    <!-- BOTON DE VOLVER-->
    <?= Html::button('Atrás', ['class' => 'my-custom-button', 'onclick' => 'location.href=\''.Url::toRoute(["index"]).'\'']) ?>

</div>
