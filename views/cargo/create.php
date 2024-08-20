<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Cargo $model */

$this->title = 'Crear Cargo';
$this->params['breadcrumbs'][] = ['label' => 'Cargo', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cargo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
