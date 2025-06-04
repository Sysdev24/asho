<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;


/**
 * This is the model class for table "suje_afec_categoria".
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
 */
class SujeAfecCategoria extends \yii\db\ActiveRecord
{
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'suje_afec_categoria';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent_id'], 'default', 'value' => null],

            [['id_estatus'], 'default', 'value' => 1],

            [['name', 'parent_path', 'id_estatus'], 'required'],

            [['parent_id', 'id_estatus'], 'integer'],

            [['name', 'codigo'], 'string'],

            [['created_at', 'updated_at'], 'safe'],

            [['complete_name'], 'string', 'max' => 512],

            [['parent_path'], 'string', 'max' => 32],

            [['id_estatus'], 'exist', 'skipOnError' => true, 'targetClass' => Estatus::class, 'targetAttribute' => ['id_estatus' => 'id_estatus']],
            
            ['name', 'filter', 'filter' => 'trim'], //eliminar espacios

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
            'id' => 'ID',
            'parent_id' => 'Categoria',
            'name' => 'Nombre',
            'complete_name' => 'Complete Name',
            'parent_path' => 'Parent Path',
            'codigo' => 'Codigo',
            'created_at' => 'Created At',
            'update_at' => 'Update At',
            'id_estatus' => 'Estatus',
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->name = mb_strtoupper($this->name);
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

    public static function getCategoryParentArrayList($id)
    {
        $query = self::find()->where(['parent_id' => null])->orderBy('name ASC');
        $models = $query->all();

        $rows = [];
        foreach ($models as $model) {
            $rows[$model->id] = $model->name;
        }

        return $rows;
    }

    public function getChildren()
    {
        return $this->hasMany(SujeAfecCategoria::className(), ['parent_id' => 'id'])
            ->orderBy(['codigo' => SORT_ASC]); // Ordena los hijos por 'id'
    }

    public function getParent()
    {
        return $this->hasOne(SujeAfecCategoria::className(), ['id' => 'parent_id']);
    }

    /**
     * {@inheritdoc}
     * @return SujeafeccategoriaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SujeafeccategoriaQuery(get_called_class());
    }
}
