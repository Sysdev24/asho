<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\RegistroReglaOro $model */

$this->title = $model->id_registro_regla_oro;

\yii\web\YiiAsset::register($this);
?>
<div class="registro-regla-oro-view">

    <h1><?= Html::encode($this->title) ?></h1>

   <br>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id_registro_regla_oro',
            'id_nro_accidente:boolean',
            'id_opcion1:boolean',
            'id_opcion2:boolean',
            'id_opcion3:boolean',
            'id_opcion4:boolean',
            'id_opcion_5:boolean',
            'id_estatus',
            'created_at',
            'updated_at',
        ],
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
