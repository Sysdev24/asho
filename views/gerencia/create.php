<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Gerencia $model */

$this->title = 'Crear Gerencia';
$this->params['breadcrumbs'][] = ['label' => 'Gerencia', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gerencia-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
