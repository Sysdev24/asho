<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Personal $model */

$this->title = 'Editar Personal: ' . $model->ci;
$this->params['breadcrumbs'][] = ['label' => 'Personals', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ci, 'url' => ['view', 'ci' => $model->ci]];
$this->params['breadcrumbs'][] = 'Editar';
?>
<div class="personal-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
