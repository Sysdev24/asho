<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\PersonaNatural $model */

$this->title = 'Update Persona Natural: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Persona Naturals', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="persona-natural-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
