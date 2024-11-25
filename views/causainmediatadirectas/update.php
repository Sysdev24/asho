<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\CausaInmediataDirectas $model */

$this->title = 'Update Causa Inmediata Directas: ' . $model->id_cau_inm_dir;
$this->params['breadcrumbs'][] = ['label' => 'Causa Inmediata Directas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_cau_inm_dir, 'url' => ['view', 'id_cau_inm_dir' => $model->id_cau_inm_dir]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="causa-inmediata-directas-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
