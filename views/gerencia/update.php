<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Gerencia $model */

$this->title = 'Editar Gerencia: ' . $model->descripcion;
$this->params['breadcrumbs'][] = ['label' => 'Gerencia', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->descripcion, 'url' => ['view', 'id_gerencia' => $model->id_gerencia]];
$this->params['breadcrumbs'][] = 'Editar';
?>
<div class="gerencia-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
