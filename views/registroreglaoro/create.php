<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\RegistroReglaOro $model */

$this->title = 'Crear Registro de Regla Oro';
$this->params['breadcrumbs'][] = ['label' => 'Registro de Regla de Oro', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="registro-regla-oro-create">

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
