<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "session".
 *
 * @property string $id Contiene el id de clave primaria e incremental
 * @property int|null $user_id Usuario de la sesion clave foranea de la tabla usuario
 * @property string $ip Direccion IP
 * @property string|null $user_agent Navegador
 * @property bool|null $is_trusted De confianza
 * @property int|null $expire Fecha de creacion
 * @property resource|null $data
 *
 * @property Usuarios $user
 */
class Session extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'session';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'ip'], 'required'],
            [['user_id', 'expire'], 'default', 'value' => null],
            [['user_id', 'expire'], 'integer'],
            [['is_trusted'], 'boolean'],
            [['data'], 'bytea'],
            [['id'], 'string', 'max' => 64],
            [['ip'], 'string', 'max' => 40],
            [['user_agent'], 'string', 'max' => 256],
            [['created_at', 'updated_at'], 'safe'],
            [['id'], 'unique'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::class, 'targetAttribute' => ['user_id' => 'id_usuario']],
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
            'user_id' => 'User ID',
            'ip' => 'Ip',
            'user_agent' => 'User Agent',
            'is_trusted' => 'Is Trusted',
            'expire' => 'Expire',
            'data' => 'Data',
            'created_at' => 'created_at',
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
     * @return SessionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SessionQuery(get_called_class());
    }
}
