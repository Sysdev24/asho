<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "usuarios".
 *
 * @property int $id_usuario clave unica del usuario
 * @property string|null $ci cedula de usuario
 * @property string|null $usuario usuario a utlizar en el sistema
 * @property string|null $password clave a utilizar en el sistema
 * @property string|null $nombre nombres de los usuarios
 * @property string|null $apellido apellidos de los usuarios
 * @property string|null $email email de los usuarios
 * @property int|null $id_estatus estatus del registro Activo o Inactivo
 * @property int|null $id_gerencia id de la gerencia al que pertenece el usuario
 * @property int|null $id_roles id del rol asignado a los usuarios
 * @property string|null $created_at fecha y hora de creacion del registro
 * @property string|null $updated_at fecha y hora de la modificacion del registro
 *
 * @property Estatus $estatus
 * @property Gerencia $gerencia
 * @property Roles $roles
 */
class Usuarios extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'usuarios';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ci', 'usuario', 'password', 'nombre', 'apellido', 'email'], 'string'],
            [['id_estatus', 'id_gerencia', 'id_roles'], 'default', 'value' => null],
            [['id_estatus', 'id_gerencia', 'id_roles'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['id_estatus'], 'exist', 'skipOnError' => true, 'targetClass' => Estatus::class, 'targetAttribute' => ['id_estatus' => 'id_estatus']],
            [['id_gerencia'], 'exist', 'skipOnError' => true, 'targetClass' => Gerencia::class, 'targetAttribute' => ['id_gerencia' => 'id_gerencia']],
            [['id_roles'], 'exist', 'skipOnError' => true, 'targetClass' => Roles::class, 'targetAttribute' => ['id_roles' => 'id_roles']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_usuario' => 'Id Usuario',
            'ci' => 'Ci',
            'usuario' => 'Usuario',
            'password' => 'Password',
            'nombre' => 'Nombre',
            'apellido' => 'Apellido',
            'email' => 'Email',
            'id_estatus' => 'Id Estatus',
            'id_gerencia' => 'Id Gerencia',
            'id_roles' => 'Id Roles',
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
        return $this->hasOne(Estatus::class, ['id_estatus' => 'id_estatus'])->inverseOf('usuarios');
    }

    /**
     * Gets query for [[Gerencia]].
     *
     * @return \yii\db\ActiveQuery|GerenciaQuery
     */
    public function getGerencia()
    {
        return $this->hasOne(Gerencia::class, ['id_gerencia' => 'id_gerencia'])->inverseOf('usuarios');
    }

    /**
     * Gets query for [[Roles]].
     *
     * @return \yii\db\ActiveQuery|RolesQuery
     */
    public function getRoles()
    {
        return $this->hasOne(Roles::class, ['id_roles' => 'id_roles'])->inverseOf('usuarios');
    }

    /**
     * {@inheritdoc}
     * @return UsuariosQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UsuariosQuery(get_called_class());
    }
}
