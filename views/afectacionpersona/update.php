<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\AfectacionPersona $model */

$this->title = 'Editar Afectacion Persona: ' . $model->descripcion;
$this->params['breadcrumbs'][] = ['label' => 'Afectacion Personas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->descripcion, 'url' => ['view', 'id_area_afectada' => $model->id_area_afectada]];
$this->params['breadcrumbs'][] = 'Editar';
?>
<div class="afectacion-persona-update">

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
