<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\NaturalezaAccidente $model */

$this->title = 'Crear Naturaleza de Accidente';
$this->params['breadcrumbs'][] = ['label' => 'Naturaleza de Accidentes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="naturaleza-accidente-create">

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
