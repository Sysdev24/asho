<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\TipoTrabajo $model */

$this->title = 'Create Tipo Trabajo';
$this->params['breadcrumbs'][] = ['label' => 'Tipo Trabajos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipo-trabajo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
