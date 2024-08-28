<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\PeligroAgente $model */

$this->title = 'Editar Peligro Agente: ' . $model->descripcion;

?>
<div class="peligro-agente-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

    <!-- BOTON DE VOLVER-->
    <?= Html::button('Atras', ['class' => 'my-custom-button', 'onclick' => 'goBack()']) ?>

        <script>
            function goBack() {
                window.history.back();
            }
        </script>

    </div>

</div>
