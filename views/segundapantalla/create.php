<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\SegundaPantalla $model */

$this->title = 'Crear Pantalla 24 horas';
//$this->params['breadcrumbs'][] = ['label' => 'Segunda Pantalla', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="segunda-pantalla-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
