<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "regiones".
 *
 * @property int $id_regiones clave unica de las regiones
 * @property string|null $descripcion descripcion de las regiones
 * @property int|null $id_estatus estatus del registro Activo o Inactivo
 * @property string|null $created_at fecha y hora de creacion del registro
 * @property string|null $updated_at fecha y hora de la modificacion del registro
 *
 * @property Estados[] $estados
 * @property Estatus $estatus
 * @property Registro[] $registros
 */
class Regiones extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'regiones';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descripcion'], 'string'],
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
            'id_regiones' => 'Regiones',
            'descripcion' => 'Descripcion',
            'id_estatus' => 'Estatus',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Estados]].
     *
     * @return \yii\db\ActiveQuery|EstadosQuery
     */
    public function getEstados()
    {
        return $this->hasMany(Estados::class, ['id_regiones' => 'id_regiones']);
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
     * Gets query for [[Registros]].
     *
     * @return \yii\db\ActiveQuery|RegistroQuery
     */
    public function getRegistros()
    {
        return $this->hasMany(Registro::class, ['id_region' => 'id_regiones']);
    }

    /**
     * {@inheritdoc}
     * @return RegionesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RegionesQuery(get_called_class());
    }
}
