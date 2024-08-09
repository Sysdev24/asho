<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\ClasificacionIncidente $model */

$this->title = 'Create Clasificacion Incidente';
$this->params['breadcrumbs'][] = ['label' => 'Clasificacion Incidentes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clasificacion-incidente-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
