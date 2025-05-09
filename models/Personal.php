<?php

namespace app\models;

use Yii;
use yii\db\Query;

use app\utiles\sensibleMayuscMinuscValidator;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;


/**
 * This is the model class for table "personal".
 *
 * @property int $ci Se archiva la cedula del usuario 
 * @property string|null $nombre Se archiva el nombre del usuario 
 * @property string|null $apellido Se archiva el apellido del usuario 
 * @property int|null $nro_empleado SE guarda el nro de personal de la persona
 * @property int|null $id_gerencia Se archiva el id de la gerencia general 
 * @property int|null $id_estado
 * @property int|null $id_estatus
 * @property int|null $id_cargo
 * @property string|null $created_at Se archiva cuando fue creado
 * @property string|null $updated_at Se archiva cuando fue eliminado
 * @property string|null $telefono
 * @property string|null $fecha_nac
 * @property int|null $id_registro
 * @property string|null $nacionalidad
 * @property string|null $correo
 *
 * @property Cargo $cargo
 * @property Estados $estado
 * @property Estatus $estatus
 * @property Gerencia $gerencia
 * @property Registro[] $registros
 * @property Registro[] $registros0
 * @property Registro[] $registros1
 * @property Registro[] $registros2
 * @property Registro[] $registros3
 * @property Registro[] $registros4
 */
class Personal extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'personal';
    }
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
        
            [['nacionalidad', 'ci', 'id_estado'], 'required'],
            [['nacionalidad'], 'in', 'range' => ['E', 'V', 'v', 'e'], 'message' => '* Nacionalidad no válida.'],
            [['ci'], 'integer', 'message' => '* La cédula debe ser un número.'],
            [['ci'], 'unique'],
            [['ci', 'nro_empleado', 'id_gerencia', 'id_estado', 'id_cargo'], 'default', 'value' => null],
            [['id_estatus'], 'default', 'value' => 1],
            [['ci','nro_empleado', 'id_gerencia', 'id_estado', 'id_estatus', 'id_cargo'], 'integer'],
            [['nro_empleado'], 'unique'],
            [['id_gerencia', 'id_estado', 'id_estatus', 'id_cargo'], 'required'],
            [['nombre', 'apellido', 'nacionalidad', 'telefono', 'observacion'], 'string'],
            [['nombre', 'apellido', 'telefono', 'nacionalidad'], 'required'],
            [['created_at', 'updated_at', 'fecha_nac'], 'safe'],
            [['id_cargo'], 'exist', 'skipOnError' => true, 'targetClass' => Cargo::class, 'targetAttribute' => ['id_cargo' => 'id_cargo']],
            [['id_estado'], 'exist', 'skipOnError' => true, 'targetClass' => Estados::class, 'targetAttribute' => ['id_estado' => 'id_estado']],
            [['id_estatus'], 'exist', 'skipOnError' => true, 'targetClass' => Estatus::class, 'targetAttribute' => ['id_estatus' => 'id_estatus']],
            [['id_gerencia'], 'exist', 'skipOnError' => true, 'targetClass' => Gerencia::class, 'targetAttribute' => ['id_gerencia' => 'id_gerencia']],
            [['ci'], sensibleMayuscMinuscValidator::class, 'on' => self::SCENARIO_CREATE],   
            ['telefono', 'match', 'pattern' => '/^[0-9]{11}$/', 'message' => '* Número de teléfono no válido.'],
            [['correo'], 'required'],
            [['correo'], 'email', 'message' => '* El formato del correo electrónico no es válido.'],
            //['correo', 'match', 'pattern' => '/^[a-zA-Z0-9._%+-]+@(gmail\.com|hotmail\.com|corpoelec\.gob\.ve)$/', 'message' => '* El correo electrónico debe ser: @gmail.com, @hotmail.com o @corpoelec.gob.ve.'],
            ['correo', 'match', 'pattern' =>  '/^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)([a-zA-Z]{2,5})$/'], // Expresión regular personalizada
            [['nombre', 'apellido', 'telefono', 'correo', 'ci', 'nro_empleado'], 'match', 'pattern' => '/^\S+(?: \S+)*$/', 'message' => '* No se permiten espacios al principio o al final.'],

            ['fecha_nac', 'validateAge'], // Añadir la validación personalizada
                
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
            'ci' => 'C.I.',
            'nombre' => 'Nombre',
            'apellido' => 'Apellido',
            'nro_empleado' => 'Nro de Empleado',
            'id_gerencia' => 'Gerencia',
            'id_estado' => 'Estado',
            'id_estatus' => 'Estatus',
            'id_cargo' => 'Cargo',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'telefono' => 'Telefono',
            'fecha_nac' => 'Fecha de Nacimiento',
            'nacionalidad' => 'Nacionalidad',
            'correo' => 'Correo',
            'observacion' => 'Observacion',
        ];
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        if (!$insert && array_key_exists('id_estatus', $changedAttributes) && $this->id_estatus == 2) { // Suponiendo que 2 es el estatus de INACTIVO
            $usuario = Usuarios::findOne(['ci' => $this->ci]);
            if ($usuario) {
                $usuario->id_estatus = 2; // Marcar al usuario como inactivo
                $usuario->save(false, ['id_estatus']); // Guardar el estatus sin validaciones
            }
        }
    }


    // public function buscarInformacionPersona($ci)
    // {
    //     return (new \yii\db\Query())
    //         ->select(['p.ci', 'p.nombre', 'p.apellido', 'p.correo', 'g.descripcion as gerencia', 'c.descripcion as cargo'])
    //         ->from('personal p')
    //         ->innerJoin('gerencia g', 'g.id_gerencia = p.id_gerencia')
    //         ->innerJoin('cargo c', 'c.id_cargo = p.id_cargo')
    //         ->where(['p.ci' => $ci])
    //         ->one();
    // }

    public function buscarPersonaRegistro($ci)
    {
        return (new \yii\db\Query())
            ->select(['p.ci', 'p.nombre', 'p.apellido', 'p.telefono', 'p.nro_empleado', 'c.descripcion as cargo', 'g.descripcion as gerencia'])
            ->from('personal p')
            ->innerJoin('cargo c', 'c.id_cargo = p.id_cargo')
            ->innerJoin('gerencia g', 'g.id_gerencia = p.id_gerencia')
            ->where(['p.ci' => $ci])
            ->one();
    }


    public function getTelefonoFormateado()
    {
        return preg_replace('/(\d{4})(\d{4})(\d{3})/', '$1-$2-$3', $this->telefono);
    }

    public function validateAge($attribute, $params)
    {
        $dob = new \DateTime($this->$attribute);
        $today = new \DateTime();
        $age = $today->diff($dob)->y;

        if ($age < 16) {
            $this->addError($attribute, 'Debe ser mayor a 16 años para poder registrarse en el sistema.');
        }
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->nombre = mb_strtoupper($this->nombre);
            $this->apellido = mb_strtoupper($this->apellido);
            $this->nacionalidad = strtoupper($this->nacionalidad);
            return true;
        } else {
            return false;
        }
    }


    /**
     * Gets query for [[Cargo]].
     *
     * @return \yii\db\ActiveQuery|CargoQuery
     */
    public function getCargo()
    {
        return $this->hasOne(Cargo::class, ['id_cargo' => 'id_cargo'])->inverseOf('personals');
    }

    /**
     * Gets query for [[Estado]].
     *
     * @return \yii\db\ActiveQuery|EstadosQuery
     */
    public function getEstado()
    {
        return $this->hasOne(Estados::class, ['id_estado' => 'id_estado'])->inverseOf('personals');
    }

    /**
     * Gets query for [[Estatus]].
     *
     * @return \yii\db\ActiveQuery|EstatusQuery
     */
    public function getEstatus()
    {
        return $this->hasOne(Estatus::class, ['id_estatus' => 'id_estatus'])->inverseOf('personals');
    }

    /**
     * Gets query for [[Gerencia]].
     *
     * @return \yii\db\ActiveQuery|GerenciaQuery
     */
    public function getGerencia()
    {
        return $this->hasOne(Gerencia::class, ['id_gerencia' => 'id_gerencia'])->inverseOf('personals');
    }
  /**
     * Gets query for [[Nacionalidad0]].
     *
     * @return \yii\db\ActiveQuery|NacionalidadQuery
     */
    public function getNacionalidad0()
    {
        return $this->hasOne(Nacionalidad::class, ['letra' => 'nacionalidad']);
    }
    /**
     * Gets query for [[Registros]].
     *
     * @return \yii\db\ActiveQuery|RegistroQuery
     */
    public function getRegistros()
    {
        return $this->hasMany(Registro::class, ['cedula_supervisor_60min' => 'ci'])->inverseOf('cedulaSupervisor60min');
    }

    /**
     * Gets query for [[Registros0]].
     *
     * @return \yii\db\ActiveQuery|RegistroQuery
     */
    public function getRegistros0()
    {
        return $this->hasMany(Registro::class, ['cedula_reporta' => 'ci'])->inverseOf('cedulaReporta');
    }

    /**
     * Gets query for [[Registros1]].
     *
     * @return \yii\db\ActiveQuery|RegistroQuery
     */
    public function getRegistros1()
    {
        return $this->hasMany(Registro::class, ['cedula_pers_accide' => 'ci'])->inverseOf('cedulaPersAccide');
    }

    /**
     * Gets query for [[Registros2]].
     *
     * @return \yii\db\ActiveQuery|RegistroQuery
     */
    public function getRegistros2()
    {
        return $this->hasMany(Registro::class, ['cedula_validad_60min' => 'ci'])->inverseOf('cedulaValidad60min');
    }

    /**
     * Gets query for [[Registros3]].
     *
     * @return \yii\db\ActiveQuery|RegistroQuery
     */
    public function getRegistros3()
    {
        return $this->hasMany(Registro::class, ['cedula_24horas' => 'ci'])->inverseOf('cedula24horas');
    }

    /**
     * Gets query for [[Registros4]].
     *
     * @return \yii\db\ActiveQuery|RegistroQuery
     */
    public function getRegistros4()
    {
        return $this->hasMany(Registro::class, ['cedula_valid_24horas' => 'ci'])->inverseOf('cedulaValid24horas');
    }

    /**
     * {@inheritdoc}
     * @return PersonalQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PersonalQuery(get_called_class());
    }
}
