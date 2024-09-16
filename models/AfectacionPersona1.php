<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "afec_persona_1".
 *
 * @property int|null $id_area_afectada
 * @property int|null $id_sub_area_afect
 * @property int|null $id_sub2_area_afect
 * @property string|null $descripcion
 * @property string|null $codigo
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int|null $id_estatus
 */
class AfectacionPersona1 extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'afec_persona_1';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_area_afectada', 'id_sub_area_afect', 'id_sub2_area_afect', 'id_estatus'], 'default', 'value' => null],
            [['id_area_afectada', 'id_sub_area_afect', 'id_sub2_area_afect', 'id_estatus'], 'integer'],
            [['descripcion', 'codigo'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_area_afectada' => 'Id Area Afectada',
            'id_sub_area_afect' => 'Id Sub Area Afect',
            'id_sub2_area_afect' => 'Id Sub2 Area Afect',
            'descripcion' => 'Descripcion',
            'codigo' => 'Codigo',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'id_estatus' => 'Id Estatus',
        ];
    }

    /**
     * {@inheritdoc}
     * @return AfectacionPersona1Query the active query used by this AR class.
     */
    public static function find()
    {
        return new AfectacionPersona1Query(get_called_class());
    }
}
