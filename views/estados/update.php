<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Estados $model */

$this->title = 'Editar Estado: ' . $model->descripcion;
$this->params['breadcrumbs'][] = ['label' => 'Estados', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->descripcion, 'url' => ['view', 'id_estado' => $model->id_estado]];
$this->params['breadcrumbs'][] = 'Editar';
?>
<div class="estados-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
