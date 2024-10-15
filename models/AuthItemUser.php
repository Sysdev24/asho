<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "auth_item_user".
 *
 * @property int $id campo correlativo de la tabla
 * @property string|null $auth_item_name Nombre del item
 * @property int $created_by Usuario que creo el registro
 * @property int $updated_by Usuario que modifico el registro
 *
 * @property Usuarios $createdBy
 * @property Usuarios $updatedBy
 */
class AuthItemUser extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'auth_item_user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_by', 'updated_by'], 'required'],
            [['created_by', 'updated_by'], 'default', 'value' => null],
            [['created_by', 'updated_by'], 'integer'],
            [['auth_item_name'], 'string', 'max' => 64],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::class, 'targetAttribute' => ['created_by' => 'id_usuario']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::class, 'targetAttribute' => ['updated_by' => 'id_usuario']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'auth_item_name' => 'Auth Item Name',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery|UsuariosQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(Usuarios::class, ['id_usuario' => 'created_by']);
    }

    /**
     * Gets query for [[UpdatedBy]].
     *
     * @return \yii\db\ActiveQuery|UsuariosQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(Usuarios::class, ['id_usuario' => 'updated_by']);
    }

    /**
     * {@inheritdoc}
     * @return AuthItemUserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AuthItemUserQuery(get_called_class());
    }
}
