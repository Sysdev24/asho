<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\PeligroAgente $model */

$this->title = 'Editar Peligro Agente: ' . $model->descripcion;
$this->params['breadcrumbs'][] = ['label' => 'Peligro Agente', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->descripcion, 'url' => ['view', 'id_pel_agen' => $model->id_pel_agen]];
$this->params['breadcrumbs'][] = 'Editar';
?>
<div class="peligro-agente-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
