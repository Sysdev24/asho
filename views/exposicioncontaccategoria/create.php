<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\ExposicionContacCategoria $model */

$this->title = 'Create Exposicion Contac Categoria';
$this->params['breadcrumbs'][] = ['label' => 'Exposicion Contac Categorias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="exposicion-contac-categoria-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
