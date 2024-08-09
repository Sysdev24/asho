<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\TipoAccidente $model */

$this->title = 'Create Tipo Accidente';
$this->params['breadcrumbs'][] = ['label' => 'Tipo Accidentes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipo-accidente-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
