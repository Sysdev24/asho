<?php

namespace app\models;

use Yii;
use app\utiles\sensibleMayuscMinuscValidator;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "tipo_trabajo".
 *
 * @property int $id_tipo_trabajo clave unica del tipo de trabajo
 * @property string|null $descripcion descripcion del tipo de trabajo
 * @property string|null $created_at fecha y hora de creacion del registro
 * @property string|null $updated_at fecha y hora de la modificacion del registro
 * @property int|null $id_estatus estatus del registro Activo o Inactivo
 * @property string|null $codigo codigo que representa los correlativos que componen la clasificacion de los accidente laborales operacionales y ambientales
 *
 * @property Estatus $estatus
 * @property Registro[] $registros
 * @property Registro[] $registros0
 */
class TipoTrabajo extends \yii\db\ActiveRecord
{


    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tipo_trabajo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descripcion', 'codigo'], 'string'],
            [['descripcion', 'codigo'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['id_estatus'], 'default', 'value' => null],
            [['id_estatus'], 'integer'],
            [['id_estatus'], 'exist', 'skipOnError' => true, 'targetClass' => Estatus::class, 'targetAttribute' => ['id_estatus' => 'id_estatus']],
            ['descripcion', 'match', 'pattern' => '/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]{2,255}$/', 'message' => 'Solo se admiten letras.'],
            [['descripcion'], sensibleMayuscMinuscValidator::class, 'on' => self::SCENARIO_CREATE],   
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
            'id_tipo_trabajo' => 'Id Tipo Trabajo',
            'descripcion' => 'Descripcion',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'id_estatus' => 'Estatus',
            'codigo' => 'Codigo',
        ];
    }

    /**
     * Gets query for [[Estatus]].
     *
     * @return \yii\db\ActiveQuery|EstatusQuery
     */
    public function getEstatus()
    {
        return $this->hasOne(Estatus::class, ['id_estatus' => 'id_estatus'])->inverseOf('tipoTrabajos');
    }

    /**
     * Gets query for [[Registros]].
     *
     * @return \yii\db\ActiveQuery|RegistroQuery
     */
    public function getRegistros()
    {
        return $this->hasMany(Registro::class, ['id_tipo_trabajo' => 'id_tipo_trabajo'])->inverseOf('tipoTrabajo');
    }

    /**
     * Gets query for [[Registros0]].
     *
     * @return \yii\db\ActiveQuery|RegistroQuery
     */
    public function getRegistros0()
    {
        return $this->hasMany(Registro::class, ['id_tipo_trabajo' => 'id_tipo_trabajo'])->inverseOf('tipoTrabajo0');
    }

    /**
     * {@inheritdoc}
     * @return TipotrabajoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TipotrabajoQuery(get_called_class());
    }
}
