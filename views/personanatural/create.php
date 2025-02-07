<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\PersonaNatural $model */

$this->title = 'Create Persona Natural';
$this->params['breadcrumbs'][] = ['label' => 'Persona Naturals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="persona-natural-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
