<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\SegundaPantalla $model */

$this->title = 'Actualizar Pantalla 24 horas: ' . $model->id_registro;
//$this->params['breadcrumbs'][] = ['label' => 'Segunda Pantalla', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->id_registro, 'url' => ['view', 'id_registro' => $model->id_registro]];
//$this->params['breadcrumbs'][] = 'Update';
?>
<div class="segunda-pantalla-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
