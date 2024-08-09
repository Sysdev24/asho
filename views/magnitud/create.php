<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Magnitud $model */

$this->title = 'Create Magnitud';
$this->params['breadcrumbs'][] = ['label' => 'Magnituds', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="magnitud-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
