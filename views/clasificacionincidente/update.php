<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\ClasificacionIncidente $model */

$this->title = 'Update Clasificacion Incidente: ' . $model->id_clasif_accid_lab_ope_amb;
$this->params['breadcrumbs'][] = ['label' => 'Clasificacion Incidentes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_clasif_accid_lab_ope_amb, 'url' => ['view', 'id_clasif_accid_lab_ope_amb' => $model->id_clasif_accid_lab_ope_amb]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="clasificacion-incidente-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
