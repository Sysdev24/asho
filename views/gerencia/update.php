<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Gerencia $model */

$this->title = 'Update Gerencia: ' . $model->id_gerencia;
$this->params['breadcrumbs'][] = ['label' => 'Gerencias', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_gerencia, 'url' => ['view', 'id_gerencia' => $model->id_gerencia]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="gerencia-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
