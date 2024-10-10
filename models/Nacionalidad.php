<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "nacionalidad".
 *
 * @property string $letra Letra de la nacionalidad
 * @property string|null $descripcion Descripcion de la nacionalidad
 * @property int|null $id_estatus estatus del registro Activo o Inactivo
 * @property string|null $created_at fecha y hora de creacion del registro
 * @property string|null $updated_at fecha y hora de la modificacion del registro
 *
 * @property Estatus $estatus
 * @property Personal[] $personals
 * @property Usuarios[] $usuarios
 */
class Nacionalidad extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'nacionalidad';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['letra'], 'required'],
            [['letra', 'descripcion'], 'string'],
            [['id_estatus'], 'default', 'value' => null],
            [['id_estatus'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['letra'], 'unique'],
            [['id_estatus'], 'exist', 'skipOnError' => true, 'targetClass' => Estatus::class, 'targetAttribute' => ['id_estatus' => 'id_estatus']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'letra' => 'Letra',
            'descripcion' => 'Descripcion',
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
        return $this->hasOne(Estatus::class, ['id_estatus' => 'id_estatus']);
    }

    /**
     * Gets query for [[Personals]].
     *
     * @return \yii\db\ActiveQuery|PersonalQuery
     */
    public function getPersonals()
    {
        return $this->hasMany(Personal::class, ['nacionalidad' => 'letra']);
    }

    /**
     * Gets query for [[Usuarios]].
     *
     * @return \yii\db\ActiveQuery|UsuariosQuery
     */
    public function getUsuarios()
    {
        return $this->hasMany(Usuarios::class, ['nacionalidad' => 'letra']);
    }

    /**
     * {@inheritdoc}
     * @return NacionalidadQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new NacionalidadQuery(get_called_class());
    }
}
