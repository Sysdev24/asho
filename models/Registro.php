<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "registro".
 *
 * @property int $id_registro clave unica del registro
 * @property int|null $id_estado clave unica de los estados
 * @property string|null $fecha_hora fecha y hora del registro
 * @property string|null $lugar lugar donde ocurrio el accidente descripcion 60 minutos
 * @property string|null $nro_accidente numero del correlativo del accidente
 * @property int|null $cedula_supervisor_60min Se archiva la cedula de quien registra
 * @property string|null $observaciones_60min observaciones que describen los hechos en 60 minutos
 * @property bool|null $autorizado_60m supervisor que autoriza en el tiempo de 60 minutos
 * @property string|null $created_at fecha y hora de creacion del registro
 * @property string|null $updated_at fecha y hora de la modificacion del registro
 * @property int|null $id_estatus_proceso clave unica del estatus
 * @property int|null $id_region clave unica de las regiones
 * @property string|null $acciones_tomadas_60min Acciones que se deben tomar en el rango de 60 minutos
 * @property int|null $cedula_reporta cedula de la persona que hace el reporte
 * @property int|null $cedula_pers_accide cedula de la persona que tiene el accidente
 * @property int|null $cedula_validad_60min cedula que valido el accidente en 60 minutos
 * @property int|null $id_magnitud clave unica de la magnitud
 * @property int|null $id_tipo_accidente clave unica del registro
 * @property int|null $id_tipo_trabajo clave unica del tipo de trabajo
 * @property int|null $id_peligro_agente clave unica de la tabla peli_agen_categoria
 * @property int|null $id_sujeto_afectacion id del sujeto de afectacion que tiene clave foranea de la tabla suje_afec_categoria
 * @property int|null $cedula_24horas quien registra el accidente en el proceso de 24 horas
 * @property string|null $acciones_tomadas_24horas acciones tomadas en el rango de 24 horas
 * @property string|null $observaciones_24horas observaciones de 24 horas
 * @property string|null $recomendaciones_24horas recomendaciones de 24 horas
 * @property bool|null $autorizado_24horas supervisor que autoriza en el tiempo de 24 horas
 * @property int|null $cedula_valid_24horas cedula que valido el accidente en 24 horas
 * @property string|null $descripcion_accidente_60min descripcion del accidente que ocurre en 60 minutos
 * @property int|null $id_gerencia Se registra el consecutivo de las gerencias de corpoelec
 * @property int|null $correlativo se  guarda el numero de correlativo del incidente
 * @property int|null $id_naturaleza_accidente id de la naturaleza del accidente
 * @property string|null $ocurrencia_hecho_60m descripcion del hecho de 60 minutos
 * @property string|null $acciones_tomadas_24h acciones tomadas en 24 horas
 * @property string|null $observaciones_24h observaciones de 24 horas
 * @property string|null $validado_por_24h valido el accidente en 24 horas
 * @property int|null $id_requerimiento_trabajo_24h id que se relaciona con la tabla estatus
 * @property int|null $id_afec_per_categoria id que se relaciona con la tabla afec_per_categoria
 * @property int|null $id_exposicion_con_cat id que se relaciona con la tabla exposicion_contac_categoria
 *
 * @property AfecPerCategoria $afecPerCategoria
 * @property Personal $cedula24horas
 * @property Personal $cedulaPersAccide
 * @property Personal $cedulaReporta
 * @property Personal $cedulaSupervisor60min
 * @property Personal $cedulaValid24horas
 * @property Personal $cedulaValidad60min
 * @property Estados $estado
 * @property Estatus $estatusProceso
 * @property ExposicionContacCategoria $exposicionConCat
 * @property Gerencia $gerencia
 * @property Magnitud $magnitud
 * @property NaturalezaAccidente $naturalezaAccidente
 * @property PeliAgenCategoria $peligroAgente
 * @property PersonaNatural[] $personaNaturals
 * @property Regiones $region
 * @property RegistroAdicional[] $registroAdicionals
 * @property Estatus $requerimientoTrabajo24h
 * @property SujeAfecCategoria $sujetoAfectacion
 * @property TipAccCategoria $tipoAccidente
 * @property TipoTrabajo $tipoTrabajo
 * @property TipoTrabajo $tipoTrabajo0
 */
class Registro extends \yii\db\ActiveRecord
{

    const SCENARIO_CREATE_PRIMERA = 'create';
    const SCENARIO_UPDATE = 'update';
    const SCENARIO_PRIMERA = 'primera';


    public $searchCedula;


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'registro';
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_PRIMERA] = [
            'acciones_tomadas_60min', 'observaciones_60min', 'lugar', 'cedula_supervisor_60min', 'id_estado', 'id_region', 'id_magnitud', 'id_naturaleza_accidente', 'cedula_reporta', 'created_at', 'updated_at', 'descripcion_accidente_60min', 'fecha_hora', 'cedula', 'ci'
        ];
        $scenarios[self::SCENARIO_UPDATE] = [
            'acciones_tomadas_60min', 'observaciones_60min', 'lugar', 'cedula_supervisor_60min', 'updated_at', 'descripcion_accidente_60min', 'cedula_pers_accide',
        ];
       
        return $scenarios;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [

            [['acciones_tomadas_60min', 'observaciones_60min', 'lugar', 'id_estado', 'id_region', 'id_magnitud', 'id_naturaleza_accidente', 'created_at', 'updated_at', 'descripcion_accidente_60min', 'cedula_pers_accide'], 'required', 'on' => self::SCENARIO_PRIMERA],

            [['acciones_tomadas_60min', 'observaciones_60min', 'lugar', 'id_magnitud', 'id_naturaleza_accidente', 'cedula_reporta', 'created_at', 'updated_at', 'descripcion_accidente_60min', 'cedula_pers_accide'], 'required', 'on' => self::SCENARIO_UPDATE],

           //Validació para que la cedula del supervisor solo sea requerido en las naturalezas que no sean id 31, 35
        //    [['cedula_supervisor_60min'], 'required', 'when' => function($model) {
        //     $registro = Registro::findOne(['id_naturaleza_accidente' => Yii::$app->request->post('Registro')['id_naturaleza_accidente']]);
        //     return $registro && !in_array($registro->id_naturaleza_accidente, [31, 35]);
        //     }, 'whenClient' => "function (attribute, value) {
        //         var naturalezaId = $('#naturaleza-dropdown').val();
        //         return !(naturalezaId == 31 || naturalezaId == 35);
        //     }"],



            [['cedula_pers_accide', 'cedula_supervisor_60min'], 'safe'], // Permite un array de cédulas
            [['id_estado', 'fecha_hora', 'lugar', 'nro_accidente', 'cedula_supervisor_60min', 'observaciones_60min', 'autorizado_60m', 'created_at', 'updated_at', 'id_region', 'acciones_tomadas_60min', 'cedula_reporta', /*'cedula_pers_accide',*/ 'cedula_validad_60min', 'id_magnitud', 'id_tipo_accidente', 'id_tipo_trabajo', 'id_peligro_agente', 'id_sujeto_afectacion', 'cedula_24horas', 'acciones_tomadas_24horas', 'observaciones_24horas', 'recomendaciones_24horas', 'autorizado_24horas', 'cedula_valid_24horas', 'descripcion_accidente_60min', /*'id_gerencia',*/ 'correlativo', 'id_naturaleza_accidente', 'ocurrencia_hecho_60m', 'acciones_tomadas_24h', 'observaciones_24h', 'validado_por_24h', 'id_requerimiento_trabajo_24h', 'id_afec_per_categoria', 'id_exposicion_con_cat'], 'default', 'value' => null],

            [['id_estatus_proceso'], 'default', 'value' => 6],
            [['id_estado', 'cedula_supervisor_60min', 'id_estatus_proceso', 'id_region', 'cedula_reporta', 'cedula_pers_accide', 'cedula_validad_60min', 'id_magnitud', 'id_tipo_accidente', 'id_tipo_trabajo', 'id_peligro_agente', 'id_sujeto_afectacion', 'cedula_24horas', 'cedula_valid_24horas', /*'id_gerencia',*/ 'correlativo', 'id_naturaleza_accidente', 'id_requerimiento_trabajo_24h', 'id_afec_per_categoria', 'id_exposicion_con_cat'], 'default', 'value' => null],
            [['id_estado', 'cedula_supervisor_60min', 'id_estatus_proceso', 'id_region', 'cedula_reporta', 'cedula_pers_accide', 'cedula_validad_60min', 'id_magnitud', 'id_tipo_accidente', 'id_tipo_trabajo', 'id_peligro_agente', 'id_sujeto_afectacion', 'cedula_24horas', 'cedula_valid_24horas', 'correlativo', 'id_naturaleza_accidente', 'id_requerimiento_trabajo_24h', 'id_afec_per_categoria', 'id_exposicion_con_cat'], 'integer'],
            [['fecha_hora', 'created_at', 'updated_at', 'cedula_pers_accide'], 'safe'],
            [['lugar', 'nro_accidente', 'observaciones_60min', 'acciones_tomadas_60min', 'acciones_tomadas_24horas', 'observaciones_24horas', 'recomendaciones_24horas', 'descripcion_accidente_60min', 'ocurrencia_hecho_60m', 'acciones_tomadas_24h', 'observaciones_24h', 'validado_por_24h'], 'string'],
            [['autorizado_60m', 'autorizado_24horas'], 'boolean'],
            [['id_afec_per_categoria'], 'exist', 'skipOnError' => true, 'targetClass' => AfecPerCategoria::class, 'targetAttribute' => ['id_afec_per_categoria' => 'id']],
            [['id_estado'], 'exist', 'skipOnError' => true, 'targetClass' => Estados::class, 'targetAttribute' => ['id_estado' => 'id_estado']],
            [['id_estatus_proceso'], 'exist', 'skipOnError' => true, 'targetClass' => Estatus::class, 'targetAttribute' => ['id_estatus_proceso' => 'id_estatus']],
            [['id_requerimiento_trabajo_24h'], 'exist', 'skipOnError' => true, 'targetClass' => Estatus::class, 'targetAttribute' => ['id_requerimiento_trabajo_24h' => 'id_estatus']],
            [['id_exposicion_con_cat'], 'exist', 'skipOnError' => true, 'targetClass' => ExposicionContacCategoria::class, 'targetAttribute' => ['id_exposicion_con_cat' => 'id']],
           // [['id_gerencia'], 'exist', 'skipOnError' => true, 'targetClass' => Gerencia::class, 'targetAttribute' => ['id_gerencia' => 'id_gerencia']],
            [['id_magnitud'], 'exist', 'skipOnError' => true, 'targetClass' => Magnitud::class, 'targetAttribute' => ['id_magnitud' => 'id_magnitud']],
            [['id_naturaleza_accidente'], 'exist', 'skipOnError' => true, 'targetClass' => NaturalezaAccidente::class, 'targetAttribute' => ['id_naturaleza_accidente' => 'id_naturaleza_accidente']],
            [['id_peligro_agente'], 'exist', 'skipOnError' => true, 'targetClass' => PeliAgenCategoria::class, 'targetAttribute' => ['id_peligro_agente' => 'id']],
            [['cedula_supervisor_60min'], 'exist', 'skipOnError' => true, 'targetClass' => Personal::class, 'targetAttribute' => ['cedula_supervisor_60min' => 'ci']],
            [['cedula_reporta'], 'exist', 'skipOnError' => true, 'targetClass' => Personal::class, 'targetAttribute' => ['cedula_reporta' => 'ci']],
            [['cedula_pers_accide'], 'exist', 'skipOnError' => true, 'targetClass' => Personal::class, 'targetAttribute' => ['cedula_pers_accide' => 'ci']],
            [['cedula_validad_60min'], 'exist', 'skipOnError' => true, 'targetClass' => Personal::class, 'targetAttribute' => ['cedula_validad_60min' => 'ci']],
            [['cedula_24horas'], 'exist', 'skipOnError' => true, 'targetClass' => Personal::class, 'targetAttribute' => ['cedula_24horas' => 'ci']],
            [['cedula_valid_24horas'], 'exist', 'skipOnError' => true, 'targetClass' => Personal::class, 'targetAttribute' => ['cedula_valid_24horas' => 'ci']],
            [['id_region'], 'exist', 'skipOnError' => true, 'targetClass' => Regiones::class, 'targetAttribute' => ['id_region' => 'id_regiones']],
            [['id_sujeto_afectacion'], 'exist', 'skipOnError' => true, 'targetClass' => SujeAfecCategoria::class, 'targetAttribute' => ['id_sujeto_afectacion' => 'id']],
            [['id_tipo_accidente'], 'exist', 'skipOnError' => true, 'targetClass' => TipAccCategoria::class, 'targetAttribute' => ['id_tipo_accidente' => 'id']],
            [['id_tipo_trabajo'], 'exist', 'skipOnError' => true, 'targetClass' => TipoTrabajo::class, 'targetAttribute' => ['id_tipo_trabajo' => 'id_tipo_trabajo']],
            [['id_tipo_trabajo'], 'exist', 'skipOnError' => true, 'targetClass' => TipoTrabajo::class, 'targetAttribute' => ['id_tipo_trabajo' => 'id_tipo_trabajo']],

            [['searchCedula'], 'match', 'pattern' => '/^[0-9]{8}$/', 'message' => 'La cedula debe tener 8 dígitos.'],
           
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
            'id_registro' => 'Id Registro',
            'id_estado' => 'Estado',
            'fecha_hora' => 'Fecha y Hora',
            'lugar' => 'Lugar',
            'nro_accidente' => 'Nro Accidente',
            'cedula_supervisor_60min' => '',
            'observaciones_60min' => 'Observaciones',
            'autorizado_60m' => 'Autorizado 60m',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'id_estatus_proceso' => 'Estatus Proceso',
            'id_region' => 'Región',
            'acciones_tomadas_60min' => 'Acciones Tomadas',
            'cedula_reporta' => 'Cédula que Reporta',
            'cedula_pers_accide' => 'C.I. Accidentado',
            'cedula_validad_60min' => 'Cédula Validad 60min',
            'id_magnitud' => 'Magnitud',
            'id_tipo_accidente' => 'Id Tipo Accidente',
            'id_tipo_trabajo' => 'Id Tipo Trabajo',
            'id_peligro_agente' => 'Id Peligro Agente',
            'id_sujeto_afectacion' => 'Id Sujeto Afectacion',
            'cedula_24horas' => 'Cedula 24horas',
            'acciones_tomadas_24horas' => 'Acciones Tomadas 24horas',
            'observaciones_24horas' => 'Observaciones 24horas',
            'recomendaciones_24horas' => 'Recomendaciones 24horas',
            'autorizado_24horas' => 'Autorizado 24horas',
            'cedula_valid_24horas' => 'Cedula Valid 24horas',
            'descripcion_accidente_60min' => 'Descripción del Accidente',
            'id_gerencia' => 'Id Gerencia',
            'correlativo' => 'Correlativo',
            'id_naturaleza_accidente' => 'Naturaleza Accidente',
            'ocurrencia_hecho_60m' => 'Ocurrencia Hecho 60m',
            'acciones_tomadas_24h' => 'Acciones Tomadas 24h',
            'observaciones_24h' => 'Observaciones 24h',
            'validado_por_24h' => 'Validado Por 24h',
            'id_requerimiento_trabajo_24h' => 'Id Requerimiento Trabajo 24h',
            'id_afec_per_categoria' => 'Id Afec Per Categoria',
            'id_exposicion_con_cat' => 'Id Exposicion Con Cat',
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            // Para poner en mayúsculas
            $this->lugar = mb_strtoupper($this->lugar);

            //
            if (parent::beforeSave($insert)) {
                if ($insert) {
                    // Calcula el orden basado en el número de personas registradas para este id_registro
                    $ultimoOrden = self::find()->where(['id_registro' => $this->id_registro])->count();
                    $this->orden_persona = $ultimoOrden + 1; // Asigna el siguiente número de orden
                }
            }

            return true;
        }

        return false;
    }

    public function GenerarNumeroAccidente(){
        $estado = Estados::findOne($this->id_estado);
        $codigoRegion = $estado ? $estado->codigo_region : '00';
        $year = date('y');

        $ultimoAccidente = Registro::find()
            ->where(['like', 'nro_accidente', $codigoRegion . '0' . $year . '%', false])
            ->orderBy(['nro_accidente' => SORT_DESC])
            ->one();

        $correlativo = $ultimoAccidente ? 
            str_pad((int)substr($ultimoAccidente->nro_accidente, 5, 5) + 1, 5, '0', STR_PAD_LEFT) : 
            '00001';

        $naturalezaAccidente = NaturalezaAccidente::findOne($this->id_naturaleza_accidente);
        $descripcionNaturaleza = $naturalezaAccidente ? $naturalezaAccidente->codigo : '';
        
        $this->nro_accidente  = $codigoRegion . '0' . $year . $correlativo . $descripcionNaturaleza;

        return $this->nro_accidente;
        
    }

  

    public function validateSupervisorCedula($attribute, $params)
    {
        if ($this->cedula_pers_accide == $this->cedula_supervisor_60min) {
            $this->addError($attribute, 'El supervisor no puede ser la persona afectada.');
        }
    }

    public function getPersonal()
    {
        return $this->hasOne(Personal::class, ['ci' => 'cedula_pers_accide']);
    }

    /**
     * Gets query for [[AfecPerCategoria]].
     *
     * @return \yii\db\ActiveQuery|AfecpercategoriaQuery
     */
    public function getAfecPerCategoria()
    {
        return $this->hasOne(AfecPerCategoria::class, ['id' => 'id_afec_per_categoria']);
    }
    

    /**
     * Gets query for [[Cedula24horas]].
     *
     * @return \yii\db\ActiveQuery|PersonalQuery
     */
    public function getCedula24horas()
    {
        return $this->hasOne(Personal::class, ['ci' => 'cedula_24horas']);
    }

    /**
     * Gets query for [[CedulaPersAccide]].
     *
     * @return \yii\db\ActiveQuery|PersonalQuery
     */
    public function getCedulaPersAccide()
    {
        return $this->hasOne(Personal::class, ['ci' => 'cedula_pers_accide']);
    }

    /**
     * Gets query for [[CedulaReporta]].
     *
     * @return \yii\db\ActiveQuery|PersonalQuery
     */
    public function getCedulaReporta()
    {
        return $this->hasOne(Personal::class, ['ci' => 'cedula_reporta']);
    }

    /**
     * Gets query for [[CedulaSupervisor60min]].
     *
     * @return \yii\db\ActiveQuery|PersonalQuery
     */
    public function getCedulaSupervisor60min()
    {
        return $this->hasOne(Personal::class, ['ci' => 'cedula_supervisor_60min']);
    }

    /**
     * Gets query for supervisor que puede ser de Personal o PersonaNatural
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSupervisor()
    {
        // Primero intenta encontrar en Personal
        $supervisorPersonal = $this->hasOne(Personal::class, ['ci' => 'cedula_supervisor_60min']);
        
        // Si no existe en Personal, busca en PersonaNatural
        if (!$supervisorPersonal->exists()) {
            return $this->hasOne(PersonaNatural::class, ['cedula' => 'cedula_supervisor_60min']);
        }
        
        return $supervisorPersonal;
    }

    /**
     * Gets query for [[CedulaValid24horas]].
     *
     * @return \yii\db\ActiveQuery|PersonalQuery
     */
    public function getCedulaValid24horas()
    {
        return $this->hasOne(Personal::class, ['ci' => 'cedula_valid_24horas']);
    }

    /**
     * Gets query for [[CedulaValidad60min]].
     *
     * @return \yii\db\ActiveQuery|PersonalQuery
     */
    public function getCedulaValidad60min()
    {
        return $this->hasOne(Personal::class, ['ci' => 'cedula_validad_60min']);
    }

    /**
     * Gets query for [[Estado]].
     *
     * @return \yii\db\ActiveQuery|EstadosQuery
     */
    public function getEstado()
    {
        return $this->hasOne(Estados::class, ['id_estado' => 'id_estado']);
    }

    /**
     * Gets query for [[EstatusProceso]].
     *
     * @return \yii\db\ActiveQuery|EstatusQuery
     */
    public function getEstatusProceso()
    {
        return $this->hasOne(Estatus::class, ['id_estatus' => 'id_estatus_proceso']);
    }

    /**
     * Gets query for [[ExposicionConCat]].
     *
     * @return \yii\db\ActiveQuery|ExposicioncontaccategoriaQuery
     */
    public function getExposicionConCat()
    {
        return $this->hasOne(ExposicionContacCategoria::class, ['id' => 'id_exposicion_con_cat']);
    }

    /**
     * Gets query for [[Gerencia]].
     *
     * @return \yii\db\ActiveQuery|GerenciaQuery
     */
    public function getGerencia()
    {
        return $this->hasOne(Gerencia::class, ['id_gerencia' => 'id_gerencia']);
    }

    /**
     * Gets query for [[Magnitud]].
     *
     * @return \yii\db\ActiveQuery|MagnitudQuery
     */
    public function getMagnitud()
    {
        return $this->hasOne(Magnitud::class, ['id_magnitud' => 'id_magnitud']);
    }

    /**
     * Gets query for [[NaturalezaAccidente]].
     *
     * @return \yii\db\ActiveQuery|NaturalezaaccidenteQuery
     */
    public function getNaturalezaAccidente()
    {
        return $this->hasOne(NaturalezaAccidente::class, ['id_naturaleza_accidente' => 'id_naturaleza_accidente']);
    }

    /**
     * Gets query for [[PeligroAgente]].
     *
     * @return \yii\db\ActiveQuery|PeliagencategoriaQuery
     */
    public function getPeligroAgente()
    {
        return $this->hasOne(PeliAgenCategoria::class, ['id' => 'id_peligro_agente']);
    }

    /**
     * Gets query for [[PersonaNaturals]].
     *
     * @return \yii\db\ActiveQuery|PersonanaturalQuery
     */
    public function getPersonaNaturals()
    {
        return $this->hasMany(PersonaNatural::class, ['id_registro' => 'id_registro']);
    }

    /**
     * Gets query for [[Region]].
     *
     * @return \yii\db\ActiveQuery|RegionesQuery
     */
    public function getRegion()
    {
        return $this->hasOne(Regiones::class, ['id_regiones' => 'id_region']);
    }

    /**
     * Gets query for [[RegistroAdicionals]].
     *
     * @return \yii\db\ActiveQuery|RegistroAdicionalQuery
     */
    public function getRegistroAdicionals()
    {
        return $this->hasMany(RegistroAdicional::class, ['id_registro' => 'id_registro']);
    }

    /**
     * Gets query for [[RequerimientoTrabajo24h]].
     *
     * @return \yii\db\ActiveQuery|EstatusQuery
     */
    public function getRequerimientoTrabajo24h()
    {
        return $this->hasOne(Estatus::class, ['id_estatus' => 'id_requerimiento_trabajo_24h']);
    }

    /**
     * Gets query for [[SujetoAfectacion]].
     *
     * @return \yii\db\ActiveQuery|SujeafeccategoriaQuery
     */
    public function getSujetoAfectacion()
    {
        return $this->hasOne(SujeAfecCategoria::class, ['id' => 'id_sujeto_afectacion']);
    }

    /**
     * Gets query for [[TipoAccidente]].
     *
     * @return \yii\db\ActiveQuery|TipacccategoriaQuery
     */
    public function getTipoAccidente()
    {
        return $this->hasOne(TipAccCategoria::class, ['id' => 'id_tipo_accidente']);
    }

    /**
     * Gets query for [[TipoTrabajo]].
     *
     * @return \yii\db\ActiveQuery|TipotrabajoQuery
     */
    public function getTipoTrabajo()
    {
        return $this->hasOne(TipoTrabajo::class, ['id_tipo_trabajo' => 'id_tipo_trabajo']);
    }

    /**
     * Gets query for [[TipoTrabajo0]].
     *
     * @return \yii\db\ActiveQuery|TipotrabajoQuery
     */
    public function getTipoTrabajo0()
    {
        return $this->hasOne(TipoTrabajo::class, ['id_tipo_trabajo' => 'id_tipo_trabajo']);
    }

    /**
     * {@inheritdoc}
     * @return RegistroQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RegistroQuery(get_called_class());
    }

}