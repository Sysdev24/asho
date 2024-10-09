<?php

namespace app\models;

use Yii;
use app\utiles\sensibleMayuscMinuscValidator;

/**
 * This is the model class for table "tipo_accidente".
 *
 * @property int $id_tipo_accidente
 * @property int|null $id_sub2_tipo_accid
 * @property int|null $id_sub_tipo_accid
 * @property int|null $id_tipo_accid1 id de la 1era clasificacion del tipo de accidente
 * @property int|null $id_tipo_accid id del tipo de ccidente
 * @property string|null $descripcion descripcion del tipo de accidente
 * @property string|null $codigo codigo que representa los correlativos que componen la clasificacion de los accidente laborales operacionales y ambientales
 * @property int|null $id_estatus estatus del registro Activo o Inactivo
 * @property string|null $created_at fecha y hora de creacion del registro
 * @property string|null $updated_at fecha y hora de la modificacion del registro
 *
 * @property Estatus $estatus
 * @property Registro[] $registros
 */
class TipoAccidente extends \yii\db\ActiveRecord
{
   
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update'; 
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tipo_accidente';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_sub2_tipo_accid', 'id_sub_tipo_accid', 'id_tipo_accid1', 'id_tipo_accid', 'id_estatus'], 'default', 'value' => null],
            [['id_sub2_tipo_accid', 'id_sub_tipo_accid', 'id_tipo_accid1', 'id_tipo_accid', 'id_estatus'], 'integer'],
            [['descripcion', 'codigo'], 'string'],
            [['descripcion', 'codigo'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['id_estatus'], 'exist', 'skipOnError' => true, 'targetClass' => Estatus::class, 'targetAttribute' => ['id_estatus' => 'id_estatus']],
            ['descripcion', 'match', 'pattern' => '/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]{2,255}$/', 'message' => 'Solo se admiten letras.'],
            [['descripcion'], sensibleMayuscMinuscValidator::className(), 'on' => self::SCENARIO_CREATE],   
        
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_tipo_accidente' => 'Id Tipo Accidente',
            'id_sub2_tipo_accid' => 'Id Sub2 Tipo Accid',
            'id_sub_tipo_accid' => 'Id Sub Tipo Accid',
            'id_tipo_accid1' => 'Id Tipo Accid1',
            'id_tipo_accid' => 'Id Tipo Accid',
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
        return $this->hasOne(Estatus::class, ['id_estatus' => 'id_estatus'])->inverseOf('tipoAccidentes');
    }

    /**
     * Gets query for [[Registros]].
     *
     * @return \yii\db\ActiveQuery|RegistroQuery
     */
    public function getRegistros()
    {
        return $this->hasMany(Registro::class, ['id_tipo_accidente' => 'id_tipo_accidente'])->inverseOf('tipoAccidente');
    }

    /**
     * {@inheritdoc}
     * @return TipoaccidenteQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TipoaccidenteQuery(get_called_class());
    }
}
