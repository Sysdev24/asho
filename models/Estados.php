<?php

namespace app\models;

use Yii;
use app\utiles\sensibleMayuscMinuscValidator;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "estados".
 *
 * @property int $id_estado clave unica de los estados
 * @property string|null $descripcion descripcion de los estados
 * @property int|null $id_estatus estatus del registro Activo o Inactivo
 * @property string|null $created_at fecha y hora de creacion del registro
 * @property string|null $updated_at fecha y hora de la modificacion del registro
 * @property int|null $id_regiones
 *
 * @property Estatus $estatus
 * @property Personal[] $personals
 * @property Regiones $regiones
 */
class Estados extends \yii\db\ActiveRecord
{
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'estados';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descripcion'], 'string'],
            [['descripcion', 'id_estatus'], 'required'],
            [['id_regiones'], 'default', 'value' => null],
            [['id_estatus'], 'default', 'value' => 1],
            [['id_estatus', 'id_regiones', 'codigo_region'], 'integer'],
            [['id_estatus', 'id_regiones'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['id_estatus'], 'exist', 'skipOnError' => true, 'targetClass' => Estatus::class, 'targetAttribute' => ['id_estatus' => 'id_estatus']],
            [['id_regiones'], 'exist', 'skipOnError' => true, 'targetClass' => Regiones::class, 'targetAttribute' => ['id_regiones' => 'id_regiones']],
            ['descripcion', 'match', 'pattern' => '/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]{2,255}$/', 'message' => 'Solo se admiten letras.'],
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
            'id_estado' => 'Estado',
            'descripcion' => 'Descripcion',
            'id_estatus' => 'Estatus',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'id_regiones' => 'Regiones',
            'codigo_region' => 'Codigo de Region',
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->descripcion = mb_strtoupper($this->descripcion);
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
     * Gets query for [[Personals]].
     *
     * @return \yii\db\ActiveQuery|PersonalQuery
     */
    public function getPersonals()
    {
        return $this->hasMany(Personal::class, ['id_estado' => 'id_estado']);
    }

    /**
     * Gets query for [[Regiones]].
     *
     * @return \yii\db\ActiveQuery|RegionesQuery
     */
    public function getRegiones()
    {
        return $this->hasOne(Regiones::class, ['id_regiones' => 'id_regiones']);
    }

    /**
     * {@inheritdoc}
     * @return EstadosQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EstadosQuery(get_called_class());
    }
}
