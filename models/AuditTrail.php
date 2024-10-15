<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "audit_trail".
 *
 * @property int $id Valor unico
 * @property string|null $old_value Valor anterior
 * @property string|null $new_value Nuevo valor
 * @property string $action Acción
 * @property string $model Modelo
 * @property string|null $field Campo
 * @property string $stamp Fecha
 * @property int|null $user_id ID del usuario
 * @property int $model_id ID del modelo
 *
 * @property Usuarios $user
 */
class AuditTrail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'audit_trail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['old_value', 'new_value'], 'string'],
            [['action', 'model', 'stamp', 'model_id'], 'required'],
            [['stamp'], 'safe'],
            [['user_id', 'model_id'], 'default', 'value' => null],
            [['user_id', 'model_id'], 'integer'],
            [['action', 'field'], 'string', 'max' => 32],
            [['model'], 'string', 'max' => 128],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::class, 'targetAttribute' => ['user_id' => 'id_usuario']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'old_value' => 'Old Value',
            'new_value' => 'New Value',
            'action' => 'Action',
            'model' => 'Model',
            'field' => 'Field',
            'stamp' => 'Stamp',
            'user_id' => 'User ID',
            'model_id' => 'Model ID',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery|UsuariosQuery
     */
    public function getUser()
    {
        return $this->hasOne(Usuarios::class, ['id_usuario' => 'user_id']);
    }

    /**
     * {@inheritdoc}
     * @return AudittrailQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AudittrailQuery(get_called_class());
    }
}
