<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\RegistroReglaOro $model */

$this->title = $model->id_registro_regla_oro;
$this->params['breadcrumbs'][] = ['label' => 'Registro Regla Oros', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="registro-regla-oro-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id_registro_regla_oro' => $model->id_registro_regla_oro], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id_registro_regla_oro' => $model->id_registro_regla_oro], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

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
