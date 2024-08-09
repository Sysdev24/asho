<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\EvaluacionPotencialPerdida $model */

$this->title = 'Editar Evaluacion Potencial Perdida: ' . $model->descripcion;
$this->params['breadcrumbs'][] = ['label' => 'Evaluacion Potencial Perdidas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->descripcion, 'url' => ['view', 'id_eva_pot_per' => $model->id_eva_pot_per]];
$this->params['breadcrumbs'][] = 'Editar';
?>
<div class="evaluacion-potencial-perdida-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
