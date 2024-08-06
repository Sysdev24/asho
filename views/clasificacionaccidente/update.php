<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\ClasificacionAccidente $model */

$this->title = 'Update Clasificacion Accidente: ' . $model->id_clasif_accid_lab_ope_amb;
$this->params['breadcrumbs'][] = ['label' => 'Clasificacion Accidentes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_clasif_accid_lab_ope_amb, 'url' => ['view', 'id_clasif_accid_lab_ope_amb' => $model->id_clasif_accid_lab_ope_amb]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="clasificacion-accidente-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
