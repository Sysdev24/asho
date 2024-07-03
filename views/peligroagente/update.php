<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\PeligroAgente $model */

$this->title = 'Update Peligro Agente: ' . $model->id_pel_agen;
$this->params['breadcrumbs'][] = ['label' => 'Peligro Agentes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_pel_agen, 'url' => ['view', 'id_pel_agen' => $model->id_pel_agen]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="peligro-agente-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
