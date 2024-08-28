<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Personal $model */

$this->title = 'Crear Personal';

?>
<div class="personal-create">

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
