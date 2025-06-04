<?php

namespace app\models;

use Yii;
use app\utiles\sensibleMayuscMinuscValidator;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "estatus".
 *
 * @property int $id_estatus clave unica del estatus
 * @property string|null $siglas siglas que tienen cada estatus
 * @property string|null $descripcion descripcion del estatus
 * @property string|null $created_at fecha y hora de creacion del registro
 * @property string|null $updated_at fecha y hora de la modificacion del registro
 *
 * @property AfectacionBienesProcesos[] $afectacionBienesProcesos
 * @property AfectacionPersona[] $afectacionPersonas
 * @property Cargo[] $cargos
 * @property ClasificacionAccidente[] $clasificacionAccidentes
 * @property Estados[] $estados
 * @property Gerencia[] $gerencias
 * @property Magnitud[] $magnituds
 * @property NaturalezaAccidente[] $naturalezaAccidentes
 * @property PeligroAgente[] $peligroAgentes
 * @property Personal[] $personals
 * @property Regiones[] $regiones
 * @property RegistroReglaOro[] $registroReglaOros
 * @property Registro[] $registros
 * @property Registro[] $registros0
 * @property ReglaOro[] $reglaOros
 * @property Roles[] $roles
 * @property SujetoAfectacion[] $sujetoAfectacions
 * @property TipoAccidente[] $tipoAccidentes
 * @property TipoTrabajo[] $tipoTrabajos
 * @property Usuarios[] $usuarios
 */
class Estatus extends \yii\db\ActiveRecord
{

    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'estatus';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['siglas', 'descripcion'], 'string'],
            [['siglas', 'descripcion'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            ['descripcion', 'match', 'pattern' => '/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]{4,255}$/', 'message' => 'Solo se admiten letras.'],
            ['siglas', 'match', 'pattern' => '/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]{2,255}$/', 'message' => 'Solo se admiten letras.'],
            [['descripcion'], sensibleMayuscMinuscValidator::class, 'on' => self::SCENARIO_CREATE],
            ['descripcion', 'filter', 'filter' => 'trim'],


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
         ]; 
     }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_estatus' => 'Estatus',
            'siglas' => 'Siglas',
            'descripcion' => 'Descripcion',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->descripcion = mb_strtoupper($this->descripcion);
            $this->siglas = mb_strtoupper($this->siglas);
            return true;
        } else {
            return false;
        }
    }

    /**
     * Gets query for [[AfectacionPersonas]].
     *
     * @return \yii\db\ActiveQuery|AfectacionpersonaQuery
     */
    public function getAfectacionPersonas()
    {
        return $this->hasMany(AfecPerCategoria::class, ['id_estatus' => 'id_estatus'])->inverseOf('estatus');
    }

    /**
     * Gets query for [[Cargos]].
     *
     * @return \yii\db\ActiveQuery|CargoQuery
     */
    public function getCargos()
    {
        return $this->hasMany(Cargo::class, ['id_estatus' => 'id_estatus'])->inverseOf('estatus');
    }

    /**
     * Gets query for [[ClasificacionAccidentes]].
     *
     * @return \yii\db\ActiveQuery|ClasificacionaccidenteQuery
     */
    public function getClasificacionAccidentes()
    {
        return $this->hasMany(ClasificacionAccidente::class, ['id_estatus' => 'id_estatus'])->inverseOf('estatus');
    }

    /**
     * Gets query for [[Estados]].
     *
     * @return \yii\db\ActiveQuery|EstadosQuery
     */
    public function getEstados()
    {
        return $this->hasMany(Estados::class, ['id_estatus' => 'id_estatus'])->inverseOf('estatus');
    }

    /**
     * Gets query for [[Gerencias]].
     *
     * @return \yii\db\ActiveQuery|GerenciaQuery
     */
    public function getGerencias()
    {
        return $this->hasMany(Gerencia::class, ['id_estatus' => 'id_estatus'])->inverseOf('estatus');
    }

    /**
     * Gets query for [[Magnituds]].
     *
     * @return \yii\db\ActiveQuery|MagnitudQuery
     */
    public function getMagnituds()
    {
        return $this->hasMany(Magnitud::class, ['id_estatus' => 'id_estatus'])->inverseOf('estatus');
    }

    /**
     * Gets query for [[NaturalezaAccidentes]].
     *
     * @return \yii\db\ActiveQuery|NaturalezaaccidenteQuery
     */
    public function getNaturalezaAccidentes()
    {
        return $this->hasMany(NaturalezaAccidente::class, ['id_estatus' => 'id_estatus'])->inverseOf('estatus');
    }

    /**
     * Gets query for [[PeligroAgentes]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getPeligroAgentes()
    {
        return $this->hasMany(PeliAgenCategoria::class, ['id_estatus' => 'id_estatus'])->inverseOf('estatus');
    }

    /**
     * Gets query for [[Personals]].
     *
     * @return \yii\db\ActiveQuery|PersonalQuery
     */
    public function getPersonals()
    {
        return $this->hasMany(Personal::class, ['id_estatus' => 'id_estatus'])->inverseOf('estatus');
    }

    /**
     * Gets query for [[Regiones]].
     *
     * @return \yii\db\ActiveQuery|RegionesQuery
     */
    public function getRegiones()
    {
        return $this->hasMany(Regiones::class, ['id_estatus' => 'id_estatus'])->inverseOf('estatus');
    }

    /**
     * Gets query for [[RegistroReglaOros]].
     *
     * @return \yii\db\ActiveQuery|RegistroReglaOroQuery
     */
    public function getRegistroReglaOros()
    {
        return $this->hasMany(RegistroReglaOro::class, ['id_estatus' => 'id_estatus'])->inverseOf('estatus');
    }

    /**
     * Gets query for [[Registros]].
     *
     * @return \yii\db\ActiveQuery|RegistroQuery
     */
    public function getRegistros()
    {
        return $this->hasMany(Registro::class, ['id_estatus_proceso' => 'id_estatus'])->inverseOf('estatusProceso');
    }

    /**
     * Gets query for [[Registros0]].
     *
     * @return \yii\db\ActiveQuery|RegistroQuery
     */
    public function getRegistros0()
    {
        return $this->hasMany(Registro::class, ['id_requerimiento_trabajo_24h' => 'id_estatus'])->inverseOf('requerimientoTrabajo24h');
    }

    /**
     * Gets query for [[ReglaOros]].
     *
     * @return \yii\db\ActiveQuery|ReglaOroQuery
     */
    public function getReglaOros()
    {
        return $this->hasMany(ReglaOro::class, ['id_estatus' => 'id_estatus'])->inverseOf('estatus');
    }

    /**
     * Gets query for [[Roles]].
     *
     * @return \yii\db\ActiveQuery|RolesQuery
     */
    public function getRoles()
    {
        return $this->hasMany(Roles::class, ['id_estatus' => 'id_estatus'])->inverseOf('estatus');
    }

    /**
     * Gets query for [[SujetoAfectacions]].
     *
     * @return \yii\db\ActiveQuery|SujetoafectacionQuery
     */
    public function getSujetoAfectacions()
    {
        return $this->hasMany(SujeAfecCategoria::class, ['id_estatus' => 'id_estatus'])->inverseOf('estatus');
    }

    /**
     * Gets query for [[TipoAccidentes]].
     *
     * @return \yii\db\ActiveQuery|TipoaccidenteQuery
     */
    public function getTipoAccidentes()
    {
        return $this->hasMany(TipAccCategoria::class, ['id_estatus' => 'id_estatus'])->inverseOf('estatus');
    }

    /**
     * Gets query for [[TipoTrabajos]].
     *
     * @return \yii\db\ActiveQuery|TipotrabajoQuery
     */
    public function getTipoTrabajos()
    {
        return $this->hasMany(TipoTrabajo::class, ['id_estatus' => 'id_estatus'])->inverseOf('estatus');
    }

    /**
     * Gets query for [[Usuarios]].
     *
     * @return \yii\db\ActiveQuery|UsuariosQuery
     */
    public function getUsuarios()
    {
        return $this->hasMany(Usuarios::class, ['id_estatus' => 'id_estatus'])->inverseOf('estatus');
    }

    /**
     * {@inheritdoc}
     * @return EstatusQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EstatusQuery(get_called_class());
    }
}
