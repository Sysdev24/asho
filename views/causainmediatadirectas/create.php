<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\CausaInmediataDirectas $model */

$this->title = 'Create Causa Inmediata Directas';
$this->params['breadcrumbs'][] = ['label' => 'Causa Inmediata Directas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="causa-inmediata-directas-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
