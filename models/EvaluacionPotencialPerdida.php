<?php

namespace app\models;

use Yii;
use app\utiles\sensibleMayuscMinuscValidator;
/**
 * This is the model class for table "evaluacion_potencial_perdida".
 *
 * @property int $id_eva_pot_per clave unica de la evaluacion potencial de perdida
 * @property string|null $descripcion  descripcion de la evaluacion potencial de perdida
 * @property string|null $created_at fecha y hora de creacion del registro
 * @property string|null $updated_at fecha y hora de la modificacion del registro
 * @property int|null $id_estatus estatus del registro Activo o Inactivo
 *
 * @property Estatus $estatus
 * @property SeveridadPotencialPerdida[] $severidadPotencialPerdidas
 */
class EvaluacionPotencialPerdida extends \yii\db\ActiveRecord
{

    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'evaluacion_potencial_perdida';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descripcion'], 'string'],
            [['descripcion'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['id_estatus'], 'default', 'value' => null],
            [['id_estatus'], 'integer'],
            [['id_estatus'], 'exist', 'skipOnError' => true, 'targetClass' => Estatus::class, 'targetAttribute' => ['id_estatus' => 'id_estatus']],
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
     * Gets query for [[SeveridadPotencialPerdidas]].
     *
     * @return \yii\db\ActiveQuery|SeveridadPotencialPerdidaQuery
     */
    public function getSeveridadPotencialPerdidas()
    {
        return $this->hasMany(SeveridadPotencialPerdida::class, ['id_eva_pot_per' => 'id_eva_pot_per']);
    }

    /**
     * {@inheritdoc}
     * @return EvaluacionpotencialperdidaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EvaluacionpotencialperdidaQuery(get_called_class());
    }
}
