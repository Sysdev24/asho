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

<br>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'nacionalidad',
            'ci',
            'nombre',
            'apellido',
            'nro_empleado',
            [   
                'attribute' => 'id_gerencia',
                'label' => 'Gerencia',
                'value' => function($model){
                    return   $model->gerencia->descripcion;},
            ],

            [   
                'attribute' => 'id_estado',
                'label' => 'Estado',
                'value' => function($model){
                    return   $model->estado->descripcion;},
            ],
           
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
            'correo',
            //'id_registro',
        ],
    ]) ?>
<!-- BOTON DE VOLVER-->
<?= Html::button('Atrás', ['class' => 'my-custom-button', 'onclick' => 'location.href=\''.Url::toRoute(["index"]).'\'']) ?>
    

</div>
