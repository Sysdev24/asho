<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\CausasCb $model */

$this->title = 'Create Causas Cb';
$this->params['breadcrumbs'][] = ['label' => 'Causas Cbs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="causas-cb-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
