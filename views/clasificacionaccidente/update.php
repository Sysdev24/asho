<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\ClasificacionAccidente $model */

$this->title = 'Editar Clasificacion de Accidente: ' . $model->descripcion;
$this->params['breadcrumbs'][] = ['label' => 'Clasificacion de Accidente', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->descripcion, 'url' => ['view', 'id_clasif_accid_lab_ope_amb' => $model->id_clasif_accid_lab_ope_amb]];
$this->params['breadcrumbs'][] = 'Editar';
?>
<div class="clasificacion-accidente-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
