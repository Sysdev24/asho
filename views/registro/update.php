<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Registro $model */

$this->title = 'Actuaizar Registro: ' . $model->id_registro;
$this->params['breadcrumbs'][] = ['label' => 'Registro', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_registro, 'url' => ['view', 'id_registro' => $model->id_registro]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="registro-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
