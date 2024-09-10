<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Permisos $model */

$this->title = 'Crear Permiso';

?>
<div class="permisos-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'errorMessage' => $errorMessage,
    ]) ?>

</div>
