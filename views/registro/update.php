<?php

use yii\helpers\Html;
use yii\helpers\Url;


/** @var yii\web\View $this */
/** @var app\models\Registro $model */

$this->title = 'Actualizar Registro: ' . $model->nro_accidente;
?>
<div class="registro-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        //'modelPersonaNatural' => $modelPersonaNatural,
        //'personalData' => $personalData, // Pasar personalData a la vista
    ]) ?>

    <!-- BOTON DE VOLVER-->
    <?= Html::button('Atrás', ['class' => 'my-custom-button', 'onclick' => 'location.href=\''.Url::toRoute(["index"]).'\'']) ?>

</div>
