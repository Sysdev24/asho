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
            //[['nombre', 'apellido', 'telefono', 'empresa'], 'required'],
            [['cedula', 'nombre', 'apellido', 'telefono', 'empresa'], 'required', 'when' => function($model) {
                $registro = Registro::findOne(['id_naturaleza_accidente' => Yii::$app->request->post('Registro')['id_naturaleza_accidente']]);
                return $registro && !in_array($registro->id_naturaleza_accidente, [2, 19, 79, 61, 92]);
            }, 'whenClient' => "function (attribute, value) {
                var naturalezaId = $('#naturaleza-dropdown').val();
                return !(naturalezaId == 2 || naturalezaId == 19 || naturalezaId == 79 || naturalezaId == 61 || naturalezaId == 92);
            }"],

            //['cedula', 'string', 'length' => 8],
            [['cedula'], 'match', 'pattern' => '/^[0-9]{8}$/', 'message' => 'La cedula debe tener 8 dígitos.'],


            //['telefono', 'match', 'pattern' => '/^\d{4}\d{7}$/', 'message' => 'Formato: 04121234567'],

            //['fecha_nac', 'date', 'format' => 'php:Y-m-d'],

            [['created_at', 'updated_at', 'fecha_nac'], 'safe'],
            [['id_registro', 'cedula'], 'default', 'value' => null],
            [['id_registro', 'cedula'], 'integer'],
            ['telefono', 'match', 'pattern' => '/^[0-9]{11}$/', 'message' => '* Número de teléfono no válido.'],
            [['nombre', 'apellido', 'telefono'], 'match', 'pattern' => '/^\S+(?: \S+)*$/', 'message' => '* No se permiten espacios al principio o al final.'],
            //['nombre', 'apellido', 'telefono', 'filter' => 'trim'], //eliminar espacios
            

            [['cedula', 'nombre', 'apellido', 'telefono', 'fecha_nac', 'empresa', 'id_registro'], 'safe'],
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
            'cedula' => 'Cedula',
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            // Verifica si los atributos son arrays y los convierte a cadenas
            if (is_array($this->nombre)) {
                $this->nombre = implode(', ', array_map('strtoupper', $this->nombre));
            } else {
                $this->nombre = mb_strtoupper($this->nombre);
            }

            if (is_array($this->apellido)) {
                $this->apellido = implode(', ', array_map('strtoupper', $this->apellido));
            } else {
                $this->apellido = mb_strtoupper($this->apellido);
            }

            if (is_array($this->empresa)) {
                $this->empresa = implode(', ', array_map('strtoupper', $this->empresa));
            } else {
                $this->empresa = mb_strtoupper($this->empresa);
            }

            return true;
        } else {
            return false;
        }
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
