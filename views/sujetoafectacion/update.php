<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\SujetoAfectacion $model */

$this->title = 'Update Sujeto Afectacion: ' . $model->id_sujeto_afect;
$this->params['breadcrumbs'][] = ['label' => 'Sujeto Afectacions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_sujeto_afect, 'url' => ['view', 'id_sujeto_afect' => $model->id_sujeto_afect]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="sujeto-afectacion-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
