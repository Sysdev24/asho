<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Magnitud $model */

$this->title = 'Editar Magnitud: ' . $model->descripcion;
$this->params['breadcrumbs'][] = ['label' => 'Magnituds', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->descripcion, 'url' => ['view', 'id_magnitud' => $model->id_magnitud]];
$this->params['breadcrumbs'][] = 'Editar';
?>
<div class="magnitud-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
