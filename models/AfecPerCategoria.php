<?php

namespace app\models;

use Yii;
use app\utiles\sensibleMayuscMinuscValidator;


/**
 * This is the model class for table "afec_per_categoria".
 *
 * @property int $id
 * @property int|null $parent_id
 * @property string|null $name
 * @property string|null $complete_name
 * @property string|null $parent_path
 * @property string|null $codigo
 * @property string|null $created_at
 * @property string|null $update_at
 * @property int|null $id_estatus
 *
 * @property Estatus $estatus
 */
class AfecPerCategoria extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'afec_per_categoria';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'parent_path'], 'required'],
            [['parent_id', 'id_estatus'], 'default', 'value' => null],
            [['parent_id', 'id_estatus'], 'integer'],
            [['name', 'codigo'], 'string'],
            [['created_at', 'update_at'], 'safe'],
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
            'name' => 'Nombre',
            'complete_name' => 'Complete Name',
            'parent_path' => 'Parent Path',
            'codigo' => 'Codigo',
            'created_at' => 'Created At',
            'update_at' => 'Update At',
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

    public function beforeSave($insert)
    {
        if ($insert && $this->parent_id === null) {
            $lastId = self::find()->orderBy(['id' => SORT_DESC])->one()->id;
            $this->parent_id = $lastId + 1;
            $this->parent_path .= ($lastId + 1);
        }
        return parent::beforeSave($insert);
    }
    

    /**
     * {@inheritdoc}
     * @return AfecpercategoriaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AfecpercategoriaQuery(get_called_class());
    }
}
