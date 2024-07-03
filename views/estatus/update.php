<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Estatus $model */

$this->title = 'Actualizar Estatus: ' . $model->descripcion;
$this->params['breadcrumbs'][] = ['label' => 'Estatus', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->descripcion, 'url' => ['view', 'id_estatus' => $model->id_estatus]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="estatus-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
