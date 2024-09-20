<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\Personal $model */

$this->title = $model->ci;

\yii\web\YiiAsset::register($this);
?>
<div class="personal-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['update', 'ci' => $model->ci], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'ci' => $model->ci], [
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
            'ci',
            'nombre',
            'apellido',
            'nro_empleado',
            //'id_gerencia',
            [   
                'attribute' => 'id_gerencia',
                'label' => 'Gerencia',
                'value' => function($model){
                    return   $model->gerencia->descripcion;},
            ],

            //'id_estado',
            [   
                'attribute' => 'id_estado',
                'label' => 'Estado',
                'value' => function($model){
                    return   $model->estado->descripcion;},
            ],
            //'id_estatus',
            [   
                'attribute' => 'id_estatus',
                'label' => 'Estatus',
                'value' => function($model){
                    return   $model->estatus->descripcion;},
            ],

            //'id_cargo',
            //'created_at',
            //'updated_at',
            'telefono',
            'fecha_nac',
            //'id_registro',
        ],
    ]) ?>
<!-- BOTON DE VOLVER-->
<?= Html::button('Atrás', ['class' => 'my-custom-button', 'onclick' => 'location.href=\''.Url::toRoute(["index"]).'\'']) ?>
    

</div>
