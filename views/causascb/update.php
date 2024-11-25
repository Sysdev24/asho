<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\CausasCb $model */

$this->title = 'Update Causas Cb: ' . $model->id_causas_cb;
$this->params['breadcrumbs'][] = ['label' => 'Causas Cbs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_causas_cb, 'url' => ['view', 'id_causas_cb' => $model->id_causas_cb]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="causas-cb-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
