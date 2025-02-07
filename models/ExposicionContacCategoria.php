<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "exposicion_contac_categoria".
 *
 * @property int $id
 * @property int|null $parent_id
 * @property string|null $name
 * @property string|null $complete_name
 * @property string|null $parent_path
 * @property string|null $codigo
 * @property int|null $id_estatus
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Estatus $estatus
 */
class ExposicionContacCategoria extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'exposicion_contac_categoria';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent_id', 'id_estatus'], 'default', 'value' => null],
            [['parent_id', 'id_estatus'], 'integer'],
            [['name', 'codigo'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['complete_name'], 'string', 'max' => 512],
            [['parent_path'], 'string', 'max' => 32],
            [['id_estatus'], 'exist', 'skipOnError' => true, 'targetClass' => Estatus::class, 'targetAttribute' => ['id_estatus' => 'id_estatus']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Parent ID',
            'name' => 'Name',
            'complete_name' => 'Complete Name',
            'parent_path' => 'Parent Path',
            'codigo' => 'Codigo',
            'id_estatus' => 'Id Estatus',
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
     * @return ExposicioncontaccategoriaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ExposicioncontaccategoriaQuery(get_called_class());
    }
}
