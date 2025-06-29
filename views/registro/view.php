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

            <div>
                <br>
                <h3>Sujeto de afectacion</h3>
                <br>
            </div>

        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [

                [
                    'attribute' => 'cedula_pers_accide',
                    'value' => function($model) {
                        // Verifica si la cédula está seteada, si no, devuelve 'N/A'
                        // Aquí asumimos que un valor de 1 en la base de datos indica 'N/A'
                        if (is_null($model->cedula_pers_accide) || $model->cedula_pers_accide == 1) {
                            return 'N/A';
                        }
                        return $model->cedula_pers_accide;
                    },
                    'filterInputOptions' => ['class' => 'form-control', 'placeholder' => 'Busqueda'],
                ],

                [
                    'attribute' => 'nombre',
                    'label' => 'Nombre',
                    'value' => function($model) {
                        if (!empty($model->personaNaturals)) {
                            return $model->personaNaturals[0]->nombre; // Accede al primer elemento
                        } elseif ($model->cedulaPersAccide) {
                            return $model->cedulaPersAccide->nombre;
                        }
                        return 'Nombre no disponible';
                    }
                ],

                [
                    'attribute' => 'apellido',
                    'label' => 'Apellido',
                    'value' => function($model) {
                        if (!empty($model->personaNaturals)) {
                            return $model->personaNaturals[0]->apellido; // Accede al primer elemento
                        } elseif ($model->cedulaPersAccide) {
                            return $model->cedulaPersAccide->apellido;
                        }
                        return 'Apellido no disponible';
                    }
                ],

                [
                    'attribute' => 'nro_empleado',
                    'label' => 'Nro Personal',
                    'value' => function($model){
                        return $model->cedulaPersAccide && $model->cedulaPersAccide->nro_empleado
                            ? $model->cedulaPersAccide->nro_empleado
                            : 'Nro personal no disponible';
                    },
                ],
            
                
                [
                    'attribute' => 'fecha_nac',
                    'label' => 'Fecha Nacimiento',
                    'value' => function($model) {
                        // Buscar en personaNatural primero
                        if (!empty($model->personaNaturals)) {
                            foreach ($model->personaNaturals as $personaNatural) {
                                if (!empty($personaNatural->fecha_nac)) {
                                    return Yii::$app->formatter->asDate($personaNatural->fecha_nac, 'php:d-m-Y');
                                }
                            }
                        }
                        
                        // Si no encontró en personaNatural, buscar en personal
                        if (!empty($model->cedulaPersAccide) && !empty($model->cedulaPersAccide->fecha_nac)) {
                            return Yii::$app->formatter->asDate($model->cedulaPersAccide->fecha_nac, 'php:d-m-Y');
                        }
                        
                        if (!empty($model->cedulaReporta) && !empty($model->cedulaReporta->fecha_nac)) {
                            return Yii::$app->formatter->asDate($model->cedulaReporta->fecha_nac, 'php:d-m-Y');
                        }
                
                        return 'No disponible';
                    }
                ],

                [
                    'attribute' => 'edad',
                    'value' => function($model) {
                        // Determinar de qué tabla obtener la fecha de nacimiento
                        $fechaNacimiento = null;
                        
                        // Primero verifica si hay una persona natural asociada
                        if (!empty($model->personaNaturals)) {
                            foreach ($model->personaNaturals as $personaNatural) {
                                if (!empty($personaNatural->fecha_nac)) {
                                    $fechaNacimiento = $personaNatural->fecha_nac;
                                    break;
                                }
                            }
                        }
                        
                        // Si no encontró en personaNatural, verifica en personal
                        if (empty($fechaNacimiento)) {
                            if (!empty($model->cedulaPersAccide)) {
                                $fechaNacimiento = $model->cedulaPersAccide->fecha_nac;
                            } elseif (!empty($model->cedulaReporta)) {
                                $fechaNacimiento = $model->cedulaReporta->fecha_nac;
                            }
                        }
                
                        // Mostrar en el log para debug
                        Yii::info("Fecha obtenida: " . print_r($fechaNacimiento, true), 'application');
                
                        // Calcular la edad si la fecha de nacimiento está disponible
                        if (!empty($fechaNacimiento)) {
                            try {
                                $fechaNac = new DateTime($fechaNacimiento);
                                $hoy = new DateTime();
                                $diferencia = $hoy->diff($fechaNac);
                                return $diferencia->y;
                            } catch (Exception $e) {
                                Yii::error("Error al calcular la edad: " . $e->getMessage(), 'application');
                                return 'Error en fecha';
                            }
                        }
                
                        return 'Fecha no disponible';
                    }
                ],

                [
                    'attribute' => 'id_gerencia',
                    'label' => 'Gerencia',
                    'value' => function($model){
                        return $model->cedulaPersAccide && $model->cedulaPersAccide->gerencia
                            ? $model->cedulaPersAccide->gerencia->descripcion
                            : 'N/A';
                    },
                ],
            ],

        ]) ?>

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
                

                // 'autorizado_60m:boolean',
                //'created_at',
                //'updated_at',
                //'id_estatus_proceso',
                //'id_region',
                // 'cedula_validad_60min',
                // 'id_tipo_accidente',
                // 'id_tipo_trabajo',
                // 'id_peligro_agente',
                // 'id_sujeto_afectacion',
                // 'id_afecta_bienes_perso',
                // 'cedula_24horas',
                // 'acciones_tomadas_24horas',
                // 'observaciones_24horas',
                // 'recomendaciones_24horas',
                // 'autorizado_24horas:boolean',
                // 'cedula_valid_24horas',
                // 'recomendaciones_60m',
                // 'anno',
                // 'correlativo',
                // //'id_naturaleza_accidente',
                // 'ocurrencia_hecho_60m',
                // 'acciones_tomadas_24h',
                // 'observaciones_24h',
                // 'validado_por_24h',
                // 'id_requerimiento_trabajo_24h',
                // 'cumple_regla_oro:boolean',
                // 'id_afec_per_categoria',
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

                'descripcion_accidente_60min',
            ],

        ]) ?>

    <!-- BOTON DE VOLVER-->
   <?= Html::button('Atrás', ['class' => 'my-custom-button', 'onclick' => 'location.href=\''.Url::toRoute(["index"]).'\'']) ?>

</div>
