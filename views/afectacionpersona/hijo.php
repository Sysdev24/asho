<?php

use yii\grid\GridView;

/** @var yii\data\ActiveDataProvider $dataProvider */

?>

<div class="afectacion-persona-index">
    <h1>Afectación Persona</h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['attribute' => 'id_area_afectada'],
            ['attribute' => 'id_sub_area_afect'],
            ['attribute' => 'id_sub2_area_afect'],
            ['attribute' => 'descripcion'],
            ['attribute' => 'codigo'],
            ['attribute' => 'created_at'],
            ['attribute' => 'updated_at'],
            ['attribute' => 'id_estatus'],
        ],
    ]); ?>
</div>