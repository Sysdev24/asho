<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\Usuarios $model */

$this->title = $model->username;

\yii\web\YiiAsset::register($this);
?>
<div class="usuarios-view">

    <br>
        <h3><?= Html::encode($this->title) ?></h3>
    <br>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [

            [
                'attribute' => 'personal.nacionalidad',
                'label' => 'Nacionalidad',
                'filterInputOptions' => [
                    'class' => 'form-control',
                    'placeholder' => 'Busqueda',
                ],
            ],
            'ci',
            'username',
            
            [
                'attribute' => 'personal.nombre',
                'label' => 'Nombre',
                'filterInputOptions' => [
                    'class' => 'form-control',
                    'placeholder' => 'Busqueda',
                ],
            ],

            [   
                'attribute' => 'personal.apellido',
                'label' => 'Apellido',
                'filterInputOptions' => [
                    'class' => 'form-control',
                    'placeholder' => 'Busqueda',
                ],
            ],
           
            [   
                'attribute' => 'personal.cargo.descripcion',
                'label' => 'Cargo',
                'filterInputOptions' => [
                    'class' => 'form-control',
                    'placeholder' => 'Busqueda',
                ],
            ],
            
            [
                'attribute' => 'personal.gerencia.descripcion',
                'label' => 'Gerencia',
                'filterInputOptions' => [
                    'class' => 'form-control',
                    'placeholder' => 'Busqueda',
                ],
            ],

            [   
                'attribute' => 'personal.correo',
                'label' => 'Correo',
                'filterInputOptions' => [
                    'class' => 'form-control',
                    'placeholder' => 'Busqueda',
                ],
            ],
             
            [
                'attribute' => 'id_estatus',
                'label' => 'Estatus',
                'value' => function ($model) {
                    return $model->estatus ? $model->estatus->descripcion : 'N/A';
                },
            ],

            [
                'attribute' => 'roles',
                'label' => 'Roles',
                'value' => function ($model) {
                    return implode(', ', $model->getUserRoles());
                },
            ],

            

        ],
    ]) ?>

 <!-- BOTON DE VOLVER-->
 <?= Html::button('Atrás', ['class' => 'my-custom-button', 'onclick' => 'location.href=\''.Url::toRoute(["index"]).'\'']) ?>
    

</div>
