<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\NaturalezaAccidente $model */

$this->title = 'Editar Naturaleza de Accidente: ' . $model->descripcion;
$this->params['breadcrumbs'][] = ['label' => 'Naturaleza de Accidente', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->descripcion, 'url' => ['view', 'id_naturaleza_accidente' => $model->id_naturaleza_accidente]];
$this->params['breadcrumbs'][] = 'Editar';
?>
<div class="naturaleza-accidente-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
