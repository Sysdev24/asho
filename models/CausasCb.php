<?php

namespace app\models;

use Yii;
use app\utiles\sensibleMayuscMinuscValidator;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "causas_cb".
 *
 * @property int $id_causas_cb Contiene el id de clave primaria e incremental
 * @property int|null $id_sub2_fac id de la 2do. clasificacion de causas basicas/raiz (CB)
 * @property int|null $id_sub_fac id de la 1era. clasificacion de causas basicas/raiz (CB)
 * @property int|null $id_cau_fac_bas_raiz id de la clasificacion factores de causas basicas/raiz (CB)
 * @property int|null $id_cau_bas_raiz id de la clasificacion de causas basicas/raiz (CB)
 * @property string|null $descripcion Contiene la descripcion del id
 * @property string|null $created_at Hora y Fecha de la creacion del registro
 * @property string|null $updated_at Hora y Fecha de la modificacion del registro
 * @property int|null $id_estatus Estatus del registro clave foranea
 *
 * @property Estatus $estatus
 */
class CausasCb extends \yii\db\ActiveRecord
{

    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'causas_cb';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_sub2_fac', 'id_sub_fac', 'id_cau_fac_bas_raiz', 'id_cau_bas_raiz', 'id_estatus'], 'default', 'value' => null],
            [['id_sub2_fac', 'id_sub_fac', 'id_cau_fac_bas_raiz', 'id_cau_bas_raiz', 'id_estatus'], 'integer'],
            [['descripcion'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['id_estatus'], 'exist', 'skipOnError' => true, 'targetClass' => Estatus::class, 'targetAttribute' => ['id_estatus' => 'id_estatus']],
            ['descripcion', 'match', 'pattern' => '/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]{2,255}$/', 'message' => 'Solo se admiten letras.'],
            [['descripcion'], sensibleMayuscMinuscValidator::class, 'on' => self::SCENARIO_CREATE], 
            ['descripcion', 'match', 'pattern' => '/^\S+(?: \S+)*$/', 'message' => 'No se permiten espacios al principio o al final.'],
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
            'id_causas_cb' => 'Id Causas Cb',
            'id_sub2_fac' => 'Id Sub2 Fac',
            'id_sub_fac' => 'Id Sub Fac',
            'id_cau_fac_bas_raiz' => 'Id Cau Fac Bas Raiz',
            'id_cau_bas_raiz' => 'Id Cau Bas Raiz',
            'descripcion' => 'Descripcion',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'id_estatus' => 'Estatus',
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
     * {@inheritdoc}
     * @return CausascbQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CausascbQuery(get_called_class());
    }
}
