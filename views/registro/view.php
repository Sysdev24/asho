<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use app\models\Gerencia;

/** @var yii\web\View $this */
/** @var app\models\Registro $model */


$this->title = 'Número de accidente: ' . Html::encode($model->nro_accidente);
?>
<div class="registro-view">

    <br>
        <h3><?= Html::encode($this->title) ?></h3>
    <br>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id_registro',

            [   
                'attribute' => 'id_estatus_proceso',
                'label' => 'Estatus del proceso',
                'value' => function($model){
                    return   $model->estatusProceso->descripcion;},
            ],

            'nro_accidente',

            [
              'attribute' => 'cedula_reporta',
            'label' => 'Cédula Reporta',  
            ],

            [   
                'attribute' => 'id_region',
                'label' => 'Region',
                'value' => function($model){
                    return   $model->region->descripcion;},
            ],

            [   
                'attribute' => 'id_estado',
                'label' => 'Estado',
                'value' => function($model){
                    return   $model->estado->descripcion;},
            ],

            'fecha_hora',

            'lugar',

            [   
                'attribute' => 'id_naturaleza_accidente',
                'label' => 'Naturaleza del Accidente',
                'value' => function($model){
                    return   $model->naturalezaAccidente->descripcion;},
            ],

            [
                'attribute' => 'id_registro_adicional',
                'label' => 'Naturaleza Adicional',
                'value' => function($model) {
                    // Verificar si el registro tiene naturaleza adicional
                    if (!empty($model->registroAdicionals)) {
                        foreach ($model->registroAdicionals as $registroAdicional) {
                            if ($registroAdicional->naturalezaAccidente) {
                                return $registroAdicional->naturalezaAccidente->descripcion;
                            }
                        }
                    }
                    return 'Sin Naturaleza Adicional';
                },
            ],
            

            [   
                'attribute' => 'id_magnitud',
                'label' => 'Magnitud',
                'value' => function($model){
                    return   $model->magnitud->descripcion;},
            ],

        ]
    ]) ?>

    <br>
    <h3>Sujeto(s) de afectacion</h3>
    <br>
    <!-- Mostrar siempre la tabla, independientemente del número de personas -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>C.I. Accidentado</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Nro Personal</th>
                    <th>Fecha Nacimiento</th>
                    <th>Edad</th>
                    <th>Gerencia</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($relatedAccidents as $accident): ?>
                    <tr>
                        <td><?= is_null($accident->cedula_pers_accide) || $accident->cedula_pers_accide == 1 ? 'N/A' : $accident->cedula_pers_accide ?></td>
                        <td>
                            <?php if (!empty($accident->personaNaturals)): ?>
                                <?= $accident->personaNaturals[0]->nombre ?>
                            <?php elseif ($accident->cedulaPersAccide): ?>
                                <?= $accident->cedulaPersAccide->nombre ?>
                            <?php else: ?>
                                Nombre no disponible
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if (!empty($accident->personaNaturals)): ?>
                                <?= $accident->personaNaturals[0]->apellido ?>
                            <?php elseif ($accident->cedulaPersAccide): ?>
                                <?= $accident->cedulaPersAccide->apellido ?>
                            <?php else: ?>
                                Apellido no disponible
                            <?php endif; ?>
                        </td>
                        <td>
                            <?= $accident->cedulaPersAccide && $accident->cedulaPersAccide->nro_empleado 
                                ? $accident->cedulaPersAccide->nro_empleado 
                                : 'Nro personal no disponible' ?>
                        </td>
                        <td>
                            <?php
                            $fechaNac = null;
                            if (!empty($accident->personaNaturals)) {
                                foreach ($accident->personaNaturals as $personaNatural) {
                                    if (!empty($personaNatural->fecha_nac)) {
                                        $fechaNac = $personaNatural->fecha_nac;
                                        break;
                                    }
                                }
                            } elseif ($accident->cedulaPersAccide && !empty($accident->cedulaPersAccide->fecha_nac)) {
                                $fechaNac = $accident->cedulaPersAccide->fecha_nac;
                            }
                            
                            echo $fechaNac ? Yii::$app->formatter->asDate($fechaNac, 'php:d-m-Y') : 'No disponible';
                            ?>
                        </td>
                        <td>
                            <?php
                            if (!empty($fechaNac)) {
                                try {
                                    $fechaNacimiento = new DateTime($fechaNac);
                                    $hoy = new DateTime();
                                    $diferencia = $hoy->diff($fechaNacimiento);
                                    echo $diferencia->y;
                                } catch (Exception $e) {
                                    echo 'Error en fecha';
                                }
                            } else {
                                echo 'No disponible';
                            }
                            ?>
                        </td>
                        <td>
                            <?= $accident->cedulaPersAccide && $accident->cedulaPersAccide->gerencia
                                ? $accident->cedulaPersAccide->gerencia->descripcion
                                : 'N/A' ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

        <div>
            <br>
            <h3>Supervisor</h3>
            <br>
        </div>
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [

                [
                    'attribute' => 'cedula_supervisor_60min',
                    'label' => 'Cédula',
                    'value' => function ($model) {
                        return !empty($model->cedula_supervisor_60min) ? $model->cedula_supervisor_60min : 'No aplica';
                    },
                ],
      
                [
                    'attribute' => 'supervisor.nombre',
                    'label' => 'Nombre del Supervisor',
                    'value' => function ($model) {
                        return !empty($model->supervisor) && !empty($model->supervisor->nombre)
                            ? $model->supervisor->nombre
                            : 'No aplica';
                    },
                ],
                
                [
                    'attribute' => 'supervisor.apellido',
                    'label' => 'Apellido del Supervisor',
                    'value' => function ($model) {
                        return !empty($model->supervisor) && !empty($model->supervisor->apellido)
                            ? $model->supervisor->apellido
                            : 'No aplica';
                    },
                ],
            ],

        ]) ?>

        <div>
            <br>
            <h3>Detalles</h3>
            <br>
        </div>
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [

                [
                    'attribute' => 'acciones_tomadas_60min',
                    'label' => 'Acciones tomadas',
                ],

                [
                    'attribute' => 'observaciones_60min',
                    'label' => 'Observaciones',
                ],

                [
                    'attribute' => 'descripcion_accidente_60min',
                    'label' => 'Descripción del accidente',
                ],

            ],

        ]) ?>

    <!-- BOTON DE VOLVER-->
   <?= Html::button('Atrás', ['class' => 'my-custom-button', 'onclick' => 'location.href=\''.Url::toRoute(["index"]).'\'']) ?>

</div>
