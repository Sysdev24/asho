<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\TipoTrabajo $model */

$this->title = 'Crear Tipo de Trabajo';
$this->params['breadcrumbs'][] = ['label' => 'Tipo de Trabajo', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipo-trabajo-create">

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
