<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\TipoAccidente $model */

$this->title = 'Update Tipo Accidente: ' . $model->id_tipo_accidente;
$this->params['breadcrumbs'][] = ['label' => 'Tipo Accidentes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_tipo_accidente, 'url' => ['view', 'id_tipo_accidente' => $model->id_tipo_accidente]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tipo-accidente-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
