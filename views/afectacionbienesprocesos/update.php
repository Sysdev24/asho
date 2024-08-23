<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\AfectacionBienesProcesos $model */

$this->title = 'Editar Afectacion de Bienes y Procesos: ' . $model->valor;
$this->params['breadcrumbs'][] = ['label' => 'Afectacion de Bienes y Procesos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->valor, 'url' => ['view', 'id_afec_bien_pro' => $model->id_afec_bien_pro]];
$this->params['breadcrumbs'][] = 'Editar';
?>
<div class="afectacion-bienes-procesos-update">

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
