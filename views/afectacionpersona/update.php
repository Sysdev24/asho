<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\AfectacionPersona $model */

$this->title = 'Update Afectacion Persona: ' . $model->id_area_afectada;
$this->params['breadcrumbs'][] = ['label' => 'Afectacion Personas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_area_afectada, 'url' => ['view', 'id_area_afectada' => $model->id_area_afectada]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="afectacion-persona-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
