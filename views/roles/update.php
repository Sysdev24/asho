<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Roles $model */

$this->title = 'Update Roles: ' . $model->id_roles;
$this->params['breadcrumbs'][] = ['label' => 'Roles', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_roles, 'url' => ['view', 'id_roles' => $model->id_roles]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="roles-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
