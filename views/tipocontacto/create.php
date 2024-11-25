<?php

use yii\helpers\Html;
use yii\helpers\Url;


/** @var yii\web\View $this */
/** @var app\models\TipoContacto $model */

$this->title = 'Create Tipo Contacto';
?>
<div class="tipo-contacto-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

    <!-- BOTON DE VOLVER-->
    <?= Html::button('Atrás', ['class' => 'my-custom-button', 'onclick' => 'location.href=\''.Url::toRoute(["index"]).'\'']) ?>
</div>
