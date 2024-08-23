<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\AfectacionPersona $model */

$this->title = 'Crear Afectacion Persona';
$this->params['breadcrumbs'][] = ['label' => 'Afectacion Persona', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="afectacion-persona-create">

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
