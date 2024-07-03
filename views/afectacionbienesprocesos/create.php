<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\AfectacionBienesProcesos $model */

$this->title = 'Create Afectacion Bienes Procesos';
$this->params['breadcrumbs'][] = ['label' => 'Afectacion Bienes Procesos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="afectacion-bienes-procesos-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
