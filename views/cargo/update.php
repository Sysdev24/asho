<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Cargo $model */

$this->title = 'Editar Cargo: ' . $model->descripcion;
$this->params['breadcrumbs'][] = ['label' => 'Cargo', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->descripcion, 'url' => ['view', 'id_cargo' => $model->id_cargo]];
$this->params['breadcrumbs'][] = 'Editar';
?>
<div class="cargo-update">

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
