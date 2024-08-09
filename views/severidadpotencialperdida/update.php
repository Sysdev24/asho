<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\SeveridadPotencialPerdida $model */

$this->title = 'Update Severidad Potencial Perdida: ' . $model->id_sev_pot_per;
$this->params['breadcrumbs'][] = ['label' => 'Severidad Potencial Perdidas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_sev_pot_per, 'url' => ['view', 'id_sev_pot_per' => $model->id_sev_pot_per]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="severidad-potencial-perdida-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
