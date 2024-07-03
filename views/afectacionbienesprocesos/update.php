<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\AfectacionBienesProcesos $model */

$this->title = 'Update Afectacion Bienes Procesos: ' . $model->id_afec_bien_pro;
$this->params['breadcrumbs'][] = ['label' => 'Afectacion Bienes Procesos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_afec_bien_pro, 'url' => ['view', 'id_afec_bien_pro' => $model->id_afec_bien_pro]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="afectacion-bienes-procesos-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
