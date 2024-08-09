<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\SeveridadPotencialPerdida $model */

$this->title = 'Create Severidad Potencial Perdida';
$this->params['breadcrumbs'][] = ['label' => 'Severidad Potencial Perdidas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="severidad-potencial-perdida-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
