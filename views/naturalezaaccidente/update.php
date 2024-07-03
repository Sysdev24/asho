<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\NaturalezaAccidente $model */

$this->title = 'Actualizar Naturaleza Accidente: ' . $model->descripcion;
$this->params['breadcrumbs'][] = ['label' => 'Naturaleza Accidentes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->descripcion, 'url' => ['view', 'id_naturaleza_accidente' => $model->id_naturaleza_accidente]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="naturaleza-accidente-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
