<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "auth_item".
 *
 * @property string $name
 * @property integer $type
 * @property string $description
 * @property string $rule_name
 * @property string $data
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property AuthAssignment[] $authAssignments
 * @property AuthRule $ruleName
 * @property AuthItemChild[] $authItemChildren
 * @property AuthItemChild[] $authItemChildren0
 */
class AuthItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'auth_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'type'], 'required'],
            [['type', 'created_at', 'updated_at'], 'integer'],
            [['description', 'data'], 'string'],
            [['name', 'rule_name'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('app', 'Name'),
            'type' => Yii::t('app', 'Type'),
            'description' => Yii::t('app', 'Description'),
            'rule_name' => Yii::t('app', 'Rule Name'),
            'data' => Yii::t('app', 'Data'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthAssignments()
    {
        return $this->hasMany(AuthAssignment::className(), ['item_name' => 'name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRuleName()
    {
        return $this->hasOne(AuthRule::className(), ['name' => 'rule_name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthItemChildren()
    {
        return $this->hasMany(AuthItemChild::className(), ['parent' => 'name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthItemChildren0()
    {
        return $this->hasMany(AuthItemChild::className(), ['child' => 'name']);
    }

    /**
     * @inheritdoc
     * @return AuthItemQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AuthItemQuery(get_called_class());
    }




    /**
     * Obtiene el nombre del rol sin el prefijo role_
     * @return string
     */
    public function getRoleName()
    {
    	return str_replace('role_', '', $this->name);
    }

    /**
     * Agrega el prefijo role_ al nombre del rol
     * @param string $itemName
     * @return string
     */
    public function setRoleName($itemName)
    {
    	return 'role_' . $itemName;
    }



    /**
     * Obtiene el nombre del modulo
     * @param string $itemName
     * @return string | NULL
     */
    public function getModuleName($itemName)
    {
    	$slices = explode('_', $itemName);
    	if (count($slices) > 2) {
    		return $slices[0];
    	}
    	return null;
    }

    /**
     * Obtiene el nombre del controlador
     * @param string $itemName
     * @return string
     */
    public function getControllerName($itemName)
    {
    	$slices = explode('_', $itemName);
    	$controller = (count($slices) > 2) ? $slices[1] : $slices[0];
    	return $controller;
    }

    /**
     * Obtiene el nombre de la accion
     * @param string $itemName
     * @return string
     */
    public function getActionName($itemName)
    {
    	$slices = explode('_', $itemName);
    	$action = $slices[count($slices) - 1];
    	return $action;
    }
}
