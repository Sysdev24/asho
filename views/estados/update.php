<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Estados $model */

$this->title = 'Editar Estado: ' . $model->descripcion;
$this->params['breadcrumbs'][] = ['label' => 'Estado', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->descripcion, 'url' => ['view', 'id_estado' => $model->id_estado]];
$this->params['breadcrumbs'][] = 'Editar';
?>
<div class="estados-update">

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
