<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cla_ac_lab_ope_amb".
 *
 * @property int $id_clasif_accid_lab_ope_amb clave unica de la clasificacion de los accidente laborales operacionales y ambientales
 * @property string|null $descripcion descripcion de la clasificacion de los accidente laborales operacionales y ambientales
 * @property string|null $codigo codigo que representa los correlativos que componen la clasificacion de los accidente laborales operacionales y ambientales
 * @property int|null $id_estatus estatus del registro Activo o Inactivo
 * @property string|null $created_at fecha y hora de creacion del registro
 * @property string|null $updated_at fecha y hora de la modificacion del registro
 *
 * @property Estatus $estatus
 */
class ClasificacionIncidente extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cla_ac_lab_ope_amb';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descripcion', 'codigo'], 'string'],
            [['id_estatus'], 'default', 'value' => null],
            [['id_estatus'], 'integer'],
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
            'id_clasif_accid_lab_ope_amb' => 'Id Clasif Accid Lab Ope Amb',
            'descripcion' => 'Descripcion',
            'codigo' => 'Codigo',
            'id_estatus' => 'Id Estatus',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Estatus]].
     *
     * @return \yii\db\ActiveQuery|EstatusQuery
     */
    public function getEstatus()
    {
        return $this->hasOne(Estatus::class, ['id_estatus' => 'id_estatus'])->inverseOf('clasificacionIncidentes');
    }

    /**
     * {@inheritdoc}
     * @return ClasificacionincidenteQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ClasificacionincidenteQuery(get_called_class());
    }
}
