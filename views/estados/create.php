<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Estados $model */

$this->title = 'Crear Estado';
$this->params['breadcrumbs'][] = ['label' => 'Estado', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="estados-create">

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
