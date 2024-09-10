<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\AfectacionBienesProcesos $model */

$this->title = 'Editar Afectacion de Bienes y Procesos: ' . $model->valor;

?>
<div class="afectacion-bienes-procesos-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

    <!-- BOTON DE VOLVER-->
    <?= Html::button('Atras', ['class' => 'my-custom-button', 'onclick' => 'goToAfectacionBienesProcesos()']) ?>

    <script>
        function goToAfectacionBienesProcesos() {
            // Ajusta la URL según tu estructura de proyecto y enrutamiento
            window.location.href = 'index.php?r=afectacionbienesprocesos%2Findex';
        }
    </script>

    </div>
</div>
