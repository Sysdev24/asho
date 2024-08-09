<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "naturaleza_accidente".
 *
 * @property int $id_naturaleza_accidente clave unica de la naturaleza del accidente
 * @property string|null $descripcion descripcion de la naturaleza del acciednte
 * @property string|null $codigo nomenclatura de la naturaliza del accidente
 * @property string|null $created_at fecha y hora de creacion del registro
 * @property string|null $updated_at fecha y hora de la modificacion del registro
 * @property int|null $id_estatus estatus del registro Activo o Inactivo
 *
 * @property Estatus $estatus
 * @property Registro[] $registros
 */
class NaturalezaAccidente extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'naturaleza_accidente';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descripcion', 'codigo'], 'string'],
            [['descripcion', 'codigo'], 'required'],
            [['created_at', 'updated_at', 'id_estatus'], 'safe'],
            [['id_estatus'], 'default', 'value' => null],
            [['id_estatus'], 'integer'],
            [['id_estatus'], 'exist', 'skipOnError' => true, 'targetClass' => Estatus::class, 'targetAttribute' => ['id_estatus' => 'id_estatus']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_naturaleza_accidente' => 'Naturaleza Accidente',
            'descripcion' => 'Descripcion',
            'codigo' => 'Codigo',
            //'created_at' => 'Created At',
            //'updated_at' => 'Updated At',
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
     * Gets query for [[Registros]].
     *
     * @return \yii\db\ActiveQuery|RegistroQuery
     */
    public function getRegistros()
    {
        return $this->hasMany(Registro::class, ['id_naturaliza_incidente' => 'id_naturaleza_accidente']);
    }

    /**
     * {@inheritdoc}
     * @return NaturalezaaccidenteQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new NaturalezaaccidenteQuery(get_called_class());
    }
}
