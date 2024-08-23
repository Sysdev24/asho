<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Estatus $model */

$this->title = 'Editar Estatus: ' . $model->descripcion;
$this->params['breadcrumbs'][] = ['label' => 'Estatus', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->descripcion, 'url' => ['view', 'id_estatus' => $model->id_estatus]];
$this->params['breadcrumbs'][] = 'Editar';
?>
<div class="estatus-update">

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
