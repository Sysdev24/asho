<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Regiones $model */

$this->title = 'Editar Regiones: ' . $model->descripcion;
$this->params['breadcrumbs'][] = ['label' => 'Regiones', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->descripcion, 'url' => ['view', 'id_regiones' => $model->id_regiones]];
$this->params['breadcrumbs'][] = 'Editar';
?>
<div class="regiones-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
