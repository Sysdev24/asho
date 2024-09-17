<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "afectacion_persona".
 *
 * @property int $id_area_afectada clave unica de la afectacion de persona
 * @property int|null $id_sub_area_afect id de la 1era clasificacion de la afectacion de persona 
 * @property int|null $id_sub2_area_afect id de la 2da clasificacion de la afectacion de persona
 * @property string|null $descripcion descripcion del area de la afectacion
 * @property string|null $codigo codigo que representa los correlativos que componen la clasificacion de los accidente laborales operacionales y ambientales
 * @property string|null $created_at fecha y hora de creacion del registro
 * @property string|null $updated_at fecha y hora de la modificacion del registro
 * @property int|null $id_estatus estatus del registro Activo o Inactivo
 *
 * @property Estatus $estatus
 */
class AfectacionPersona extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'afectacion_persona';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_sub_area_afect', 'id_sub2_area_afect', 'id_estatus'], 'default', 'value' => null],
            [['id_sub_area_afect', 'id_sub2_area_afect', 'id_estatus'], 'integer'],
            [['descripcion', 'codigo'], 'string'],
            [['descripcion', ], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['id_estatus'], 'exist', 'skipOnError' => true, 'targetClass' => Estatus::class, 'targetAttribute' => ['id_estatus' => 'id_estatus']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_area_afectada' => 'Id Area Afectada',
            'id_sub_area_afect' => 'Id Sub Area Afect',
            'id_sub2_area_afect' => 'Id Sub2 Area Afect',
            'descripcion' => 'Descripcion',
            'codigo' => 'Codigo',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'id_estatus' => 'Estatus',
        ];
    }

    /**
     * Gets query for [[Estatus]].
     *
     * @return \yii\db\ActiveQuery|EstatusQuery
     */
    public function getEstatus()
    {
        return $this->hasOne(Estatus::class, ['id_estatus' => 'id_estatus']);
    }

    /**
     * {@inheritdoc}
     * @return AfectacionpersonaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AfectacionpersonaQuery(get_called_class());
    }
}
