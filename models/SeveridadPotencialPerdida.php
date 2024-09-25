<?php

namespace app\models;

use Yii;
use app\utiles\sensibleMayuscMinuscValidator;

/**
 * This is the model class for table "severidad_potencial_perdida".
 *
 * @property int $id_sev_pot_per clave unica de la severidad potencial de la perdida
 * @property int|null $id_eva_pot_per clave forenea de la tabla de la evaluacion potencial de la perdida
 * @property string|null $descripcion descripcion de la severidad potencial de la perdida
 * @property string|null $created_at fecha y hora de creacion del registro
 * @property string|null $updated_at fecha y hora de la modificacion del registro
 * @property int|null $id_estatus estatus del registro Activo o Inactivo
 *
 * @property Estatus $estatus
 * @property EvaluacionPotencialPerdida $evaPotPer
 */
class SeveridadPotencialPerdida extends \yii\db\ActiveRecord
{
   
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'severidad_potencial_perdida';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_eva_pot_per', 'id_estatus'], 'default', 'value' => null],
            [['id_eva_pot_per', 'id_estatus'], 'integer'],
            [['descripcion'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['id_estatus'], 'exist', 'skipOnError' => true, 'targetClass' => Estatus::class, 'targetAttribute' => ['id_estatus' => 'id_estatus']],
            [['id_eva_pot_per'], 'exist', 'skipOnError' => true, 'targetClass' => EvaluacionPotencialPerdida::class, 'targetAttribute' => ['id_eva_pot_per' => 'id_eva_pot_per']],
            ['descripcion', 'match', 'pattern' => '/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]{4,255}$/', 'message' => 'Solo se admiten letras.'],
            [['descripcion'], sensibleMayuscMinuscValidator::className(), 'on' => self::SCENARIO_CREATE],   
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_sev_pot_per' => 'Id Sev Pot Per',
            'id_eva_pot_per' => 'Id Eva Pot Per',
            'descripcion' => 'Descripcion',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'id_estatus' => 'Estatus',
        ];
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
     * Gets query for [[EvaPotPer]].
     *
     * @return \yii\db\ActiveQuery|EvaluacionpotencialperdidaQuery
     */
    public function getEvaPotPer()
    {
        return $this->hasOne(EvaluacionPotencialPerdida::class, ['id_eva_pot_per' => 'id_eva_pot_per']);
    }

    /**
     * {@inheritdoc}
     * @return SeveridadpotencialperdidaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeveridadpotencialperdidaQuery(get_called_class());
    }
}
