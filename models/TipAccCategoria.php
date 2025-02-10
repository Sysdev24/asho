<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "tip_acc_categoria".
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
class TipAccCategoria extends \yii\db\ActiveRecord
{
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tip_acc_categoria';
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
            ['name', 'match', 'pattern' => '/^\S+(?: \S+)*$/', 'message' => 'No se permiten espacios al principio o al final.'],
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

    /**
     * Gets query for [[Estatus]].
     *
     * @return \yii\db\ActiveQuery|EstatusQuery
     */
    public function getEstatus()
    {
        return $this->hasOne(Estatus::class, ['id_estatus' => 'id_estatus']);
    }

    public static function getAfecperCategoryParentArrayList($id)
    {
        if ($id) {
            $model = self::find()->where(['parent_id' => null])->andFilterWhere(['not in', 'id', [$id]])->orderBy('name')->all();
        } else {
            $model = self::find()->where(['parent_id' => null])->orderBy('name')->all();
        }
    
        $rows = [];
        foreach ($model as $row) {
            $rows[$row->id] = $row->name;
        }
        return $rows;
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

    public function getChildren()
    {
        return $this->hasMany(TipAccCategoria::className(), ['parent_id' => 'id'])
            ->orderBy(['id' => SORT_ASC]); // Ordena los hijos por 'id'
    }

    /**
     * {@inheritdoc}
     * @return TipacccategoriaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TipacccategoriaQuery(get_called_class());
    }
}
