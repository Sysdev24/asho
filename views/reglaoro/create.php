<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\ReglaOro $model */

$this->title = 'Create Regla Oro';
$this->params['breadcrumbs'][] = ['label' => 'Regla Oros', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="regla-oro-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
