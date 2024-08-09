<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\RegistroReglaOro $model */

$this->title = 'Create Registro Regla Oro';
$this->params['breadcrumbs'][] = ['label' => 'Registro Regla Oros', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="registro-regla-oro-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
