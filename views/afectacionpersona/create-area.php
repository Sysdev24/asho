<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\AfectacionPersona $model */

$this->title = 'Crear Area Afectada';

?>
<div class="afectacion-persona-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form-area', [
        'model' => $model,
    ]) ?>

    <!-- BOTON DE VOLVER-->
    <?= Html::button('Atrás', ['class' => 'my-custom-button', 'onclick' => 'location.href=\''.Url::toRoute(["area"]).'\'']) ?>

</div>
