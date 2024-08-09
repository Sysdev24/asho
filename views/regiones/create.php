<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Regiones $model */

$this->title = 'Crear Regiones';
$this->params['breadcrumbs'][] = ['label' => 'Regiones', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="regiones-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
