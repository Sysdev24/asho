<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Magnitud $model */

$this->title = 'Editar Magnitud: ' . $model->descripcion;
$this->params['breadcrumbs'][] = ['label' => 'Magnitud', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->descripcion, 'url' => ['view', 'id_magnitud' => $model->id_magnitud]];
$this->params['breadcrumbs'][] = 'Editar';
?>
<div class="magnitud-update">

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
