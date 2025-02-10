<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "persona_natural".
 *
 * @property int $id Contiene el id de clave primaria e incremental
 * @property string|null $nombre Nombres de la persona natural que sufre el accidente
 * @property string|null $apellido Apellidos de la persona natural que sufre el accidente
 * @property string|null $created_at Hora y Fecha de la creacion del registro
 * @property string|null $updated_at Hora y Fecha de la modificacion del registro
 * @property string|null $telefono Telefono de la persona natural que sufre el accidente
 * @property string|null $fecha_nac Fecha Nacimiento de la persona natural que sufre el accidente
 * @property int|null $id_registro id clave foranea de regsitro del accidente viene de la tabla registro
 * @property string|null $empresa Empresa donde labora la persona natural que sufre el accidente
 * @property int|null $id_estatus Estatus del registro clave foranea
 * @property int|null $cedula Cedula de la persona natural
 *
 * @property Estatus $estatus
 */
class PersonaNatural extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'persona_natural';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'apellido', 'telefono', 'empresa'], 'string'],
            [['created_at', 'updated_at', 'fecha_nac'], 'safe'],
            [['id_registro', 'id_estatus', 'cedula'], 'default', 'value' => null],
            [['id_registro', 'id_estatus', 'cedula'], 'integer'],
            [['id_estatus'], 'exist', 'skipOnError' => true, 'targetClass' => Estatus::class, 'targetAttribute' => ['id_estatus' => 'id_estatus']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'apellido' => 'Apellido',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'telefono' => 'Telefono',
            'fecha_nac' => 'Fecha de Nacimiento',
            'id_registro' => 'ID Registro',
            'empresa' => 'Empresa',
            'id_estatus' => 'Estatus',
            'cedula' => 'Cedula',
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
     * @return PersonanaturalQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PersonanaturalQuery(get_called_class());
    }
}
