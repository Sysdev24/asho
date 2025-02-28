<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

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
            [['nombre', 'apellido', 'telefono', 'empresa'], 'required'],
            [['created_at', 'updated_at', 'fecha_nac'], 'safe'],
            [['id_registro', 'cedula'], 'default', 'value' => null],
            [['id_estatus'], 'default', 'value' => 1],
            [['id_registro', 'id_estatus', 'cedula'], 'integer'],
            [['id_estatus'], 'exist', 'skipOnError' => true, 'targetClass' => Estatus::class, 'targetAttribute' => ['id_estatus' => 'id_estatus']],
            ['telefono', 'match', 'pattern' => '/^[0-9]{11}$/', 'message' => '* Número de teléfono no válido.'],
            [['nombre', 'apellido', 'telefono'], 'match', 'pattern' => '/^\S+(?: \S+)*$/', 'message' => '* No se permiten espacios al principio o al final.'],
        ];
    }

    //Para utilizar los campos created_at y updated_at
    public function behaviors() 
    {
         return [ TimestampBehavior::class => [
             'class' => TimestampBehavior::class, 
             'attributes' => [ 
                ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'], 
                ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'], 
            ], 
            'value' => function() { return date('Y-m-d H:i:s'); }, // Formato para datetime 
            ], 
            
            /* AuditTrail Module */
            'LoggableBehavior' => [
                'class' => 'sammaye\audittrail\LoggableBehavior',
                'ignored' => ['auth_key','password_hash', 'created_at', 'updated_at'],
            ]
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

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->nombre = mb_strtoupper($this->nombre);
            $this->apellido = mb_strtoupper($this->apellido);
            $this->empresa = mb_strtoupper($this->empresa);
            return true;
        } else {
            return false;
        }
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
