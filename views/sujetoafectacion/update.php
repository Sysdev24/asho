<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\SujetoAfectacion $model */

$this->title = 'Actualizar Sujeto de Afectacion: ' . $model->descripcion;
$this->params['breadcrumbs'][] = ['label' => 'Sujeto de Afectacion', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->descripcion, 'url' => ['view', 'id_sujeto_afect' => $model->id_sujeto_afect]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="sujeto-afectacion-update">

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
