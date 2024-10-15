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
 * @property int|null $ci cedula de usuario
 * @property string|null $username usuario a utlizar en el sistema
 * @property string|null $password clave a utilizar en el sistema
 * @property int|null $id_estatus estatus del registro Activo o Inactivo
 * @property string|null $created_at fecha y hora de creacion del registro
 * @property string|null $updated_at fecha y hora de la modificacion del registro
 * @property string|null $authKey
 * @property string|null $accesstoken
 * //@property string|null $name
 * @property string|null $nacionalidad Nacioanlidad
 *
 * @property AuditTrail[] $auditTrails
 * @property AuthAssignment[] $authAssignments
 * @property AuthItemUser[] $authItemUsers
 * @property AuthItemUser[] $authItemUsers0
 * @property Personal $ci0
 * @property Estatus $estatus
 * @property AuthItem[] $itemNames
 * @property Nacionalidad $nacionalidad0
 * @property AuthItem $name0
 * @property Session[] $sessions
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
            [['username', 'password', 'authKey', 'accesstoken', 'name', 'nacionalidad'], 'string'],
            ['name', 'each', 'rule' => ['string']],
        	// ['name', 'in', 'range' => self::getSystemRoles(), 'allowArray' => true],

            [['ci'], 'unique'],
            [['id_estatus', 'id_gerencia'], 'default', 'value' => null],
            [['id_estatus', 'id_gerencia' ], 'integer'],
            //[['id_gerencia' ], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'exist', 'skipOnError' => true, 'targetClass' => AuthItem::class, 'targetAttribute' => ['name' => 'name']],
            [['id_estatus'], 'exist', 'skipOnError' => true, 'targetClass' => Estatus::class, 'targetAttribute' => ['id_estatus' => 'id_estatus']],
            [['nacionalidad'], 'exist', 'skipOnError' => true, 'targetClass' => Nacionalidad::class, 'targetAttribute' => ['nacionalidad' => 'letra']],
            [['ci'], 'exist', 'skipOnError' => true, 'targetClass' => Personal::class, 'targetAttribute' => ['ci' => 'ci']],
            //[['id_roles'], 'exist', 'skipOnError' => true, 'targetClass' => Roles::class, 'targetAttribute' => ['id_roles' => 'id_roles']],
            //[['ci'], 'integer', 'min' => 500000, 'max' =>99999999, 'message' => 'La cedula debe ser un numero entero'],
            [['ci'], 'required','message' => 'La cedula es requerida'],
            [['ci'], 'match', 'pattern' => '/^[0-9]{8}$/', 'message' => 'La cedula debe iniciar con V o E y tener 8 dígitos.'],
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
            'password' => 'Contraseña',
            'nombre' => 'Nombre',
            'apellido' => 'Apellido',
            'email' => 'Email',
            'id_estatus' => 'Estatus',
            'id_gerencia' => 'Gerencia',
            //'id_roles' => 'Roles',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'name' => 'Roles',
            'authKey' => 'Auth Key',
            'accesstoken' => 'Accesstoken',
            'nacionalidad' => 'Nacionalidad',
        ];
    }

    /**
     * Gets query for [[AuditTrails]].
     *
     * @return \yii\db\ActiveQuery|AudittrailQuery
     */
    public function getAuditTrails()
    {
        return $this->hasMany(AuditTrail::class, ['user_id' => 'id_usuario']);
    }

    /**
     * Gets query for [[AuthAssignments]].
     *
     * @return \yii\db\ActiveQuery|AuthAssignmentQuery
     */
    public function getAuthAssignments()
    {
        return $this->hasMany(AuthAssignment::class, ['user_id' => 'id_usuario']);
    }

    /**
     * Gets query for [[AuthItemUsers]].
     *
     * @return \yii\db\ActiveQuery|AuthItemUserQuery
     */
    public function getAuthItemUsers()
    {
        return $this->hasMany(AuthItemUser::class, ['created_by' => 'id_usuario']);
    }

    /**
     * Gets query for [[AuthItemUsers0]].
     *
     * @return \yii\db\ActiveQuery|AuthItemUserQuery
     */
    public function getAuthItemUsers0()
    {
        return $this->hasMany(AuthItemUser::class, ['updated_by' => 'id_usuario']);
    }

    /**
     * Gets query for [[Ci0]].
     *
     * @return \yii\db\ActiveQuery|PersonalQuery
     */
    /*public function getCi0()
    {
        return $this->hasOne(Personal::class, ['ci' => 'ci']);
    }*/

    public function getPersonal()
    {
        return $this->hasOne(Personal::className(), ['ci' => 'ci']);
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
     * Gets query for [[ItemNames]].
     *
     * @return \yii\db\ActiveQuery|AuthItemQuery
     */
    public function getItemNames()
    {
        return $this->hasMany(AuthItem::class, ['name' => 'item_name'])->viaTable('auth_assignment', ['user_id' => 'id_usuario']);
    }

    /**
     * Gets query for [[Nacionalidad0]].
     *
     * @return \yii\db\ActiveQuery|NacionalidadQuery
     */
    public function getNacionalidad0()
    {
        return $this->hasOne(Nacionalidad::class, ['letra' => 'nacionalidad']);
    }

    /**
     * Gets query for [[Name0]].
     *
     * @return \yii\db\ActiveQuery|AuthItemQuery
     */
    public function getName0()
    {
        return $this->hasOne(AuthItem::class, ['name' => 'name']);
    }

    /**
     * Gets query for [[Sessions]].
     *
     * @return \yii\db\ActiveQuery|SessionQuery
     */
    public function getSessions()
    {
        return $this->hasMany(Session::class, ['user_id' => 'id_usuario']);
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

    /*public function getRoleList()
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
    }*/

    public function getRoleList()
{
    $auth = Yii::$app->authManager;
    $idUsu = Yii::$app->user->identity->id;
    $userRoles = $auth->getRolesByUser($idUsu);

    $rolesModel = new RbacForm(); // Asume que tienes un modelo Roles para obtener todos los roles
    $allRoles = $rolesModel->find()->all(); // Obtiene todos los roles de la base de datos

    $list = [];
    foreach ($allRoles as $role) {
        if (ArrayHelper::keyExists($role->name, $userRoles, false)) {
            $list[$role->name] = $role->name;
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
