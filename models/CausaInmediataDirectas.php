<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "causa_inmediata_directas".
 *
 * @property int $id_cau_inm_dir Contiene el id de clave primaria e incremental
 * @property int|null $id_sub2_caus_inm_dir id de la 2da clasificacion de la causas inmediatas directas
 * @property int|null $id_sub1_caus_inm_dir id de la 1era clasificacion de la causas inmediatas directas
 * @property string|null $descripcion Contiene la descripcion del id
 * @property string|null $created_at Hora y Fecha de la creacion del registro
 * @property string|null $updated_at Hora y Fecha de la modificacion del registro
 * @property int|null $id_estatus Estatus del registro clave foranea
 *
 * @property Estatus $estatus
 */
class CausaInmediataDirectas extends \yii\db\ActiveRecord
{

    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'causa_inmediata_directas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_sub2_caus_inm_dir', 'id_sub1_caus_inm_dir'], 'default', 'value' => null],
            [['id_estatus'], 'default', 'value' => 1],
            [['id_sub2_caus_inm_dir', 'id_sub1_caus_inm_dir', 'id_estatus'], 'integer'],
            [['descripcion'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['id_estatus'], 'exist', 'skipOnError' => true, 'targetClass' => Estatus::class, 'targetAttribute' => ['id_estatus' => 'id_estatus']],
            [['descripcion'], 'required'],
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
            'id_cau_inm_dir' => 'Id Cau Inm Dir',
            'id_sub2_caus_inm_dir' => 'Id Sub2 Caus Inm Dir',
            'id_sub1_caus_inm_dir' => 'Id Sub1 Caus Inm Dir',
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
     * @return CausainmediatadirectasQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CausainmediatadirectasQuery(get_called_class());
    }
}
