<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\EvaluacionPotencialPerdida $model */

$this->title = 'Crear Evaluacion de Potencial y Perdida';
$this->params['breadcrumbs'][] = ['label' => 'Evaluacion de Potencial y Perdidas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="evaluacion-potencial-perdida-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
