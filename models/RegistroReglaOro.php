<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "registro_regla_oro".
 *
 * @property int $id_registro_regla_oro clave unica del registro de la regla de oro
 * @property bool|null $id_nro_accidente id del accidente de la tabla registro
 * @property bool|null $id_opcion1 opcion 1, verdadero o false de la tala regla de oro
 * @property bool|null $id_opcion2 opcion 2, verdadero o false de la tala regla de oro
 * @property bool|null $id_opcion3 opcion 3, verdadero o false de la tala regla de oro
 * @property bool|null $id_opcion4 opcion 4, verdadero o false de la tala regla de oro
 * @property bool|null $id_opcion_5 opcion 5, verdadero o false de la tala regla de oro
 * @property int|null $id_estatus estatus del registro Activo o Inactivo
 * @property string|null $created_at fecha y hora de creacion del registro 
 * @property string|null $updated_at fecha y hora de la modificacion del registro
 *
 * @property Estatus $estatus
 */
class RegistroReglaOro extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'registro_regla_oro';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_nro_accidente', 'id_opcion1', 'id_opcion2', 'id_opcion3', 'id_opcion4', 'id_opcion_5'], 'boolean'],
            [['id_estatus'], 'default', 'value' => null],
            [['id_estatus'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['id_estatus'], 'exist', 'skipOnError' => true, 'targetClass' => Estatus::class, 'targetAttribute' => ['id_estatus' => 'id_estatus']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_registro_regla_oro' => 'Registro Regla Oro',
            'id_nro_accidente' => 'Nro Accidente',
            'id_opcion1' => 'Opcion1',
            'id_opcion2' => 'Opcion2',
            'id_opcion3' => 'Opcion3',
            'id_opcion4' => 'Opcion4',
            'id_opcion_5' => 'Opcion 5',
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
        return $this->hasOne(Estatus::class, ['id_estatus' => 'id_estatus']);
    }

    /**
     * {@inheritdoc}
     * @return RegistroreglaoroQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RegistroreglaoroQuery(get_called_class());
    }
}
