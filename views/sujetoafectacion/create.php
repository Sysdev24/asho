<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\SujetoAfectacion $model */

$this->title = 'Create Sujeto Afectacion';
$this->params['breadcrumbs'][] = ['label' => 'Sujeto Afectacions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sujeto-afectacion-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
