<?php

namespace app\models;

use Yii;
use app\utiles\sensibleMayuscMinuscValidator;

use yii\base\NotSupportedException;
use yii\models\LoginForm;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\helpers\ArrayHelper;

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
class Usuarios extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{

    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';
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
            [['username', 'password', 'nombre', 'apellido', 'email'], 'string'],
            // [['name'], 'string'],

            ['name', 'each', 'rule' => ['string']],
        	// ['name', 'in', 'range' => self::getSystemRoles(), 'allowArray' => true],

            [['ci'], 'unique'],
            [['id_estatus', 'id_gerencia'], 'default', 'value' => null],
            [['id_estatus', 'id_gerencia' ], 'integer'],
            [['id_gerencia' ], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['id_estatus'], 'exist', 'skipOnError' => true, 'targetClass' => Estatus::class, 'targetAttribute' => ['id_estatus' => 'id_estatus']],
            [['id_gerencia'], 'exist', 'skipOnError' => true, 'targetClass' => Gerencia::class, 'targetAttribute' => ['id_gerencia' => 'id_gerencia']],
            //[['id_roles'], 'exist', 'skipOnError' => true, 'targetClass' => Roles::class, 'targetAttribute' => ['id_roles' => 'id_roles']],
            //[['ci'], 'integer', 'min' => 500000, 'max' =>99999999, 'message' => 'La cedula debe ser un numero entero'],
            [['ci'], 'required','message' => 'La cedula es requerida'],
            [['ci'], 'match', 'pattern' => '/^[VE][0-9]{8}$/', 'message' => 'La cedula debe iniciar con V o E y tener 8 dígitos.'],
            ['nombre', 'match', 'pattern' => '/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]{4,255}$/', 'message' => 'Solo se admiten letras.'],
            ['apellido', 'match', 'pattern' => '/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]{4,255}$/', 'message' => 'Solo se admiten letras.'],
            ['email', 'match', 'pattern' => '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', 'message' => 'Correo electrónico no válido.'],
            [['ci'], sensibleMayuscMinuscValidator::className(), 'on' => self::SCENARIO_CREATE],

        ];
    }
    public $name;
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_usuario' => 'Usuario',
            'ci' => 'Ci',
            'username' => 'Usuario',
            'password' => 'Password',
            'nombre' => 'Nombre',
            'apellido' => 'Apellido',
            'email' => 'Email',
            'id_estatus' => 'Estatus',
            'id_gerencia' => 'Gerencia',
            //'id_roles' => 'Roles',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'name' => 'Roles'
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

    public static function getRoles()
    {
        $auth = Yii::$app->authManager;
        $roles = $auth->getRoles();
        // $roles debe transformarse en un array valido para ArrayDataProvider
        //$aRoles = [];
        $list = [];

        foreach ($roles as $key => $val) {
            $list[] = $val;
        }
        return $list;
    }

    public function getSystemRoles()
    {
        $auth = Yii::$app->authManager;
    	$roles = $auth->getRoles();
        $list = [];
        foreach ($roles as $rol) {
            $list[] = $rol->name;
        }
        return $list;
    }

    public function getUserRoles()
    {
        // Obtiene los roles del usuario
        $auth = Yii::$app->authManager;
        $roleSelect = $auth->getRolesByUser($this->id_usuario);
        $listRoles = [];
        foreach ($roleSelect as $rol) {
            $listRoles[] = $rol->name;
    	}
        $this->name = $listRoles;
    }

    public function getRoleList()
    {
        $auth = Yii::$app->authManager;
        $idUsu = Yii::$app->user->identity->id;
    	$userRoles = $auth->getRolesByUser($idUsu);

        $list = [];

        foreach (self::getSystemRoles() as $role) {
            if (ArrayHelper::keyExists('root', $userRoles, false)) {
                $list[$role] = $role;
            } else {
                // Oculta roles 
                if ($role == 'root') {
                        continue;
                } elseif ($role == 'admin') {
                    if( !(ArrayHelper::keyExists('admin', $userRoles, false)) ) {
                        continue;
                    }
                }
                $list[$role] = $role;
            }
        }
    	return $list;
    }

    /**
     * {@inheritdoc}
     * @return UsuariosQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UsuariosQuery(get_called_class());
    }

    



    //Insertar para el login

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    public function getId()
    {
        return $this->id_usuario;
    }

    public function getAuthKey()
    {
        return $this->authKey;
    }

    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
        //throw new NotSupportedException();
    }

    //Para el login


    /**public static function findByUsername($username){
        return self::findOne(['usuario' => $username]); 
    }*/


    //Cambio en la funcion para utilizar el modelo de nuestra BD 
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }


    public function validatePassword($password){
        return $this->password === $password;
    }
    
}
