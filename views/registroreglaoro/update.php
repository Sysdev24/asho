<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\RegistroReglaOro $model */

$this->title = 'Update Registro Regla Oro: ' . $model->id_registro_regla_oro;

?>
<div class="registro-regla-oro-update">

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
