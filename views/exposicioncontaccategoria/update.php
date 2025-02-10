<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\ExposicionContacCategoria $model */

$this->title = 'Update Exposicion Contac Categoria: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Exposicion Contac Categorias', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="exposicion-contac-categoria-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
