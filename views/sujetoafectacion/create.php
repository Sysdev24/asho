<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\SujetoAfectacion $model */

$this->title = 'Crear Sujeto de Afectacion';
$this->params['breadcrumbs'][] = ['label' => 'Sujeto de Afectacion', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sujeto-afectacion-create">

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
