<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\TipoTrabajo $model */

$this->title = 'Update Tipo Trabajo: ' . $model->id_tipo_trabajo;
$this->params['breadcrumbs'][] = ['label' => 'Tipo Trabajos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_tipo_trabajo, 'url' => ['view', 'id_tipo_trabajo' => $model->id_tipo_trabajo]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tipo-trabajo-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
