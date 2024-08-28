<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\TipoAccidente $model */

$this->title = $model->descripcion;

\yii\web\YiiAsset::register($this);
?>
<div class="tipo-accidente-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['update', 'id_tipo_accidente' => $model->id_tipo_accidente], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id_tipo_accidente' => $model->id_tipo_accidente], [
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
            //'id_tipo_accidente',
            /*'id_sub2_tipo_accid',
            'id_sub_tipo_accid',
            'id_tipo_accid1',
            'id_tipo_accid',*/
            'descripcion',
            'codigo',
            /*'id_estatus',
            'created_at',
            'updated_at',*/
            [   
                'attribute' => 'id_estatus',
                'label' => 'Estatus',
                'value' => function($model){
                    return   $model->estatus->descripcion;},
            ],
        ],
    ]) ?>

    <!-- BOTON DE VOLVER-->
    <?= Html::button('Atras', ['class' => 'my-custom-button', 'onclick' => 'goBack()']) ?>

        <script>
            function goBack() {
                window.history.back();
            }
        </script>

    </div>

</div>
