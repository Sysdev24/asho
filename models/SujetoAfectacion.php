<?php

namespace app\models;

use Yii;
use app\utiles\sensibleMayuscMinuscValidator;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "sujeto_afectacion".
 *
 * @property int $id_sujeto_afect clave unica del sujeto de afectacion
 * @property int|null $id_clasif_con_afect id de la clasificacion con afectacion combinacion de sujeto de afectacion
 * @property int|null $id_con_afectacion id con afectacion en
 * @property int|null $id_afectacion id de afectacion
 * @property string|null $descripcion descripcion del sujeto de la afectacion 
 * @property string|null $codigo codigo que representa los correlativos que componen la clasificacion de los accidente laborales operacionales y ambientales
 * @property int|null $id_estatus estatus del registro Activo o Inactivo
 * @property string|null $created_at fecha y hora de creacion del registro
 * @property string|null $updated_at fecha y hora de la modificacion del registro
 *
 * @property Estatus $estatus
 * @property Registro[] $registros
 */
class SujetoAfectacion extends \yii\db\ActiveRecord
{

    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sujeto_afectacion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_clasif_con_afect', 'id_con_afectacion', 'id_afectacion', 'id_estatus'], 'default', 'value' => null],
            [['id_clasif_con_afect', 'id_con_afectacion', 'id_afectacion', 'id_estatus'], 'integer'],
            [['descripcion', 'codigo'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
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
            'id_sujeto_afect' => 'Id Sujeto Afect',
            'id_clasif_con_afect' => 'Id Clasif Con Afect',
            'id_con_afectacion' => 'Id Con Afectacion',
            'id_afectacion' => 'Id Afectacion',
            'descripcion' => 'Descripcion',
            'codigo' => 'Codigo',
            'id_estatus' => 'Estatus',
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
        return $this->hasOne(Estatus::class, ['id_estatus' => 'id_estatus'])->inverseOf('sujetoAfectacions');
    }

    /**
     * Gets query for [[Registros]].
     *
     * @return \yii\db\ActiveQuery|RegistroQuery
     */
    public function getRegistros()
    {
        return $this->hasMany(Registro::class, ['id_sujeto_afectacion' => 'id_sujeto_afect'])->inverseOf('sujetoAfectacion');
    }

    /**
     * {@inheritdoc}
     * @return SujetoafectacionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SujetoafectacionQuery(get_called_class());
    }
}
