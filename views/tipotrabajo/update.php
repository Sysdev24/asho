<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\TipoTrabajo $model */

$this->title = 'Actualizar Tipo de Trabajo: ' . $model->descripcion;
$this->params['breadcrumbs'][] = ['label' => 'Tipo de Trabajo', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->descripcion, 'url' => ['view', 'id_tipo_trabajo' => $model->id_tipo_trabajo]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="tipo-trabajo-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
