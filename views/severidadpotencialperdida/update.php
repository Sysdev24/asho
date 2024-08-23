<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\SeveridadPotencialPerdida $model */

$this->title = 'Actualizar Severidad Potencial de Perdida: ' . $model->descripcion;
$this->params['breadcrumbs'][] = ['label' => 'Severidad Potencial de Perdidas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->descripcion, 'url' => ['view', 'id_sev_pot_per' => $model->id_sev_pot_per]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="severidad-potencial-perdida-update">

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
