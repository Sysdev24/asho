<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\Permisos $model */

$this->title = 'Actualizar Permiso: ' . $model->description;

?>
<div class="permisos-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'errorMessage' => $errorMessage,
    ]) ?>
    <!-- BOTON DE VOLVER-->
<?= Html::button('Atrás', ['class' => 'my-custom-button', 'onclick' => 'location.href=\''.Url::toRoute(["index"]).'\'']) ?>
    


</div>
