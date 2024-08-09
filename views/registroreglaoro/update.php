<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\RegistroReglaOro $model */

$this->title = 'Update Registro Regla Oro: ' . $model->id_registro_regla_oro;
$this->params['breadcrumbs'][] = ['label' => 'Registro Regla Oros', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_registro_regla_oro, 'url' => ['view', 'id_registro_regla_oro' => $model->id_registro_regla_oro]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="registro-regla-oro-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
