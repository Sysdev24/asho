<?php

namespace app\models;

use Yii;
use app\utiles\sensibleMayuscMinuscValidator;


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
            [['ci'], 'required'],
            [['ci', 'nro_empleado', 'id_gerencia', 'id_estado', 'id_estatus', 'id_cargo'], 'default', 'value' => null],
            [['ci', 'nro_empleado', 'id_gerencia', 'id_estado', 'id_estatus', 'id_cargo'], 'integer'],
            [['nro_empleado', 'id_gerencia', 'id_estado', 'id_estatus', 'id_cargo'], 'required'],
            [['nombre', 'apellido', 'telefono'], 'string'],
            [['nombre', 'apellido', 'telefono'], 'required'],
            [['created_at', 'updated_at', 'fecha_nac'], 'safe'],
            [['ci'], 'unique'],
            [['id_cargo'], 'exist', 'skipOnError' => true, 'targetClass' => Cargo::class, 'targetAttribute' => ['id_cargo' => 'id_cargo']],
            [['id_estado'], 'exist', 'skipOnError' => true, 'targetClass' => Estados::class, 'targetAttribute' => ['id_estado' => 'id_estado']],
            [['id_estatus'], 'exist', 'skipOnError' => true, 'targetClass' => Estatus::class, 'targetAttribute' => ['id_estatus' => 'id_estatus']],
            [['id_gerencia'], 'exist', 'skipOnError' => true, 'targetClass' => Gerencia::class, 'targetAttribute' => ['id_gerencia' => 'id_gerencia']],
            [['ci'], sensibleMayuscMinuscValidator::className(), 'on' => self::SCENARIO_CREATE],   

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
        ];
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
