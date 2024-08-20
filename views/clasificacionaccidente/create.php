<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\ClasificacionAccidente $model */

$this->title = 'Crear Clasificacion de Accidente';
$this->params['breadcrumbs'][] = ['label' => 'Clasificacion de Accidente', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clasificacion-accidente-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
