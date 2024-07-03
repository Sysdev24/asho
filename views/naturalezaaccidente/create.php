<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\NaturalezaAccidente $model */

$this->title = 'Crear Naturaleza Accidente';
$this->params['breadcrumbs'][] = ['label' => 'Naturaleza Accidentes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="naturaleza-accidente-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
