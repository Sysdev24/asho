<?php
// app/models/SegundaPantallaRegistro.php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class SegundaPantallaRegistro extends ActiveRecord
{

    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';
    public $searchCedula;

    public static function tableName()
    {
        return 'registro';
    }

    public function rules()
    {
        return [
            // Agregar las reglas de validación para los campos de la segunda pantalla
            [['descripcion_accidente', 'causa'], 'required'],
            [['fecha_accidente'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id_estado' => 'Estado',
            'fecha_hora' => 'Fecha y Hora',
            'lugar' => 'Lugar',
            'nro_accidente' => 'Nro Accidente',
            'cedula_reporta' => 'Cedula Reporta',
            'id_magnitud' => 'Magnitud',
            'id_tipo_accidente' => 'Id Tipo Accidente',
            'id_tipo_trabajo' => 'Id Tipo Trabajo',
            'id_peligro_agente' => 'Id Peligro Agente',
            'id_sujeto_afectacion' => 'Id Sujeto Afectacion',
            'id_afec_per_categoria' => 'Id Afec Per Categoria',
            'id_exposicion_con_cat' => 'Id Exposicion Con Cat',

        ];
    }
}