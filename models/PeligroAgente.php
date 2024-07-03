<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "peligro_agente".
 *
 * @property int $id_pel_agen id del peligro combinado con agente
 * @property int|null $id_sub2_agente id de la 2da clasificacion del agente combinado con el peligreo
 * @property int|null $id_sub_agente id de la 1era clasificacion del agente combinado con el peligreo
 * @property int|null $id_agente id del agente
 * @property int|null $id_peligro id del peligro
 * @property string|null $descripcion descripcion del peligro o el ageente
 * @property string|null $codigo codigo que representa los correlativos que componen la clasificacion de los accidente laborales operacionales y ambientales
 * @property int|null $id_estatus estatus del registro Activo o Inactivo
 * @property string|null $created_at fecha y hora de creacion del registro
 * @property string|null $updated_at fecha y hora de la modificacion del registro
 *
 * @property Estatus $estatus
 * @property Registro[] $registros
 */
class PeligroAgente extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'peligro_agente';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_sub2_agente', 'id_sub_agente', 'id_agente', 'id_peligro', 'id_estatus'], 'default', 'value' => null],
            [['id_sub2_agente', 'id_sub_agente', 'id_agente', 'id_peligro', 'id_estatus'], 'integer'],
            [['descripcion', 'codigo'], 'string'],
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
            'id_pel_agen' => 'Id Pel Agen',
            'id_sub2_agente' => 'Id Sub2 Agente',
            'id_sub_agente' => 'Id Sub Agente',
            'id_agente' => 'Id Agente',
            'id_peligro' => 'Id Peligro',
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
        return $this->hasOne(Estatus::class, ['id_estatus' => 'id_estatus'])->inverseOf('peligroAgentes');
    }

    /**
     * Gets query for [[Registros]].
     *
     * @return \yii\db\ActiveQuery|RegistroQuery
     */
    public function getRegistros()
    {
        return $this->hasMany(Registro::class, ['id_peligro_agente' => 'id_pel_agen'])->inverseOf('peligroAgente');
    }

    /**
     * {@inheritdoc}
     * @return PeligroagenteQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PeligroagenteQuery(get_called_class());
    }
}
