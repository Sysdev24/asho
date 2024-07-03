<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Estatus $model */

$this->title = 'Crear Estatus';
$this->params['breadcrumbs'][] = ['label' => 'Estatus', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="estatus-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
