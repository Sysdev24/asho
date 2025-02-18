<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\PersonaNatural $model */

$this->title = $model->cedula;

\yii\web\YiiAsset::register($this);
?>
<div class="persona-natural-view">

    <br>
        <h3><?= Html::encode($this->title) ?></h3>
    <br>

    

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'nombre',
            'apellido',
            'cedula',
            //'created_at',
            //'updated_at',
            'telefono',
            'fecha_nac',
            'id_registro',
            'empresa',
          
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
