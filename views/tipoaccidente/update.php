<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\TipoAccidente $model */

$this->title = 'Actualizar Tipo de Accidente: ' . $model->descripcion;
$this->params['breadcrumbs'][] = ['label' => 'Tipo de Accidente', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->descripcion, 'url' => ['view', 'id_tipo_accidente' => $model->id_tipo_accidente]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="tipo-accidente-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
