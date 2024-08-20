<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Estados $model */

$this->title = 'Crear Estado';
$this->params['breadcrumbs'][] = ['label' => 'Estado', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="estados-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
