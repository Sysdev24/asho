<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\PersonaNatural $model */

$this->title = 'Actualizar Persona Natural: ' . $model->ci;

?>
<div class="persona-natural-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
