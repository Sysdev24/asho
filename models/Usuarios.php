<?php

namespace app\models;

use Yii;
use app\utiles\sensibleMayuscMinuscValidator;


use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;


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
 * *
 */
class Usuarios extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{

    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';
    public $searchCedula;
    public $roles;

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
            [['username', 'password_hash'], 'required'],
            [['username', 'password', 'password_hash'], 'string', 'max' => 255],
            [['username' ], 'string'],
            [['username', 'authKey', 'accesstoken'], 'string'],
            [['username'], 'unique', 'message' => 'Este usuario ya fue utilizado.'],
            [['username'], 'match', 'pattern' => '/^[A-Za-z]\d{6,7}$/', 'message' => 'El formato del código identificador es inválido. Debe ser una letra seguida de 6 o 7 números.'],
            ['username', 'filter', 'filter' => 'trim'],

            ['password_hash', 'string', 'min' => 6, 'message' => 'La contraseña debe tener mínimo 6 caracteres.'],


            ['password', 'string', 'min' => 6, 'tooShort' => 'La contraseña debe tener mínimo 6 caracteres.'],
           //['password', 'string', 'min' => 6, 'message' => 'La contraseña debe tener mínimo 6 caracteres.'],
            ['password', 'required', 'message' => 'La contraseña es obligatoria.'],


            [['roles'], 'each', 'rule' => ['string']],
            [['roles'], 'required'],
        	// ['name', 'in', 'range' => self::getSystemRoles(), 'allowArray' => true],

            [['ci'], 'unique'],
            ['ci', 'exist', 'skipOnError' => false, 'targetClass' => Personal::class, 'targetAttribute' => ['ci' => 'ci'], 'message' => 'El usuario debe estar registrado como personal.'],
            [['ci'], 'required', 'on' => self::SCENARIO_CREATE],
            [['searchCedula'], 'match', 'pattern' => '/^[0-9]{8}$/', 'message' => 'La cedula debe tener 8 dígitos.'],
            [['ci'], sensibleMayuscMinuscValidator::class, 'on' => self::SCENARIO_CREATE],
            //[['ci'], 'match', 'pattern' => '/^[0-9]{8}$/', 'message' => 'La cedula debe tener 8 dígitos.'],

            [['id_estatus'], 'default', 'value' => 1],
            [['id_estatus'], 'integer'],
            [['id_estatus'], 'exist', 'skipOnError' => true, 'targetClass' => Estatus::class, 'targetAttribute' => ['id_estatus' => 'id_estatus']],
            ['id_estatus', 'validatePersonalBeforeActivating'],

            [['created_at', 'updated_at'], 'safe'],

           // [['nacionalidad'], 'exist', 'skipOnError' => true, 'targetClass' => Nacionalidad::class, 'targetAttribute' => ['nacionalidad' => 'letra']],

          

          
           
        ];
    }

    //Para utilizar los campos created_at y updated_at
    public function behaviors()
    {
        return [
            TimestampBehavior::class => [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => function () {
                    return date('Y-m-d H:i:s');
                }, // Formato para datetime
            ],

            /* AuditTrail Module */
            'LoggableBehavior' => [
                'class' => 'sammaye\audittrail\LoggableBehavior',
                'ignored' => ['auth_key','password_hash', 'updated_at', 'created_at'],
            ]
        ];
    }

    




    public $name;
    public $password;

    //public $roles = [];
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
            'correo' => 'Correo',
            'id_estatus' => 'Estatus',
            'id_gerencia' => 'Gerencia',
            //'id_roles' => 'Roles',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'name' => 'Roles',
            'roles' => 'Roles',
            'authKey' => 'Auth Key',
            'accesstoken' => 'Accesstoken',
            'nacionalidad' => 'Nacionalidad',
        ];
    }
    //Se encripta la contraseña
    public function setPassword($password) 
    { 
        $this->password_hash = Yii::$app->getSecurity()->generatePasswordHash($password); 
    } 

    public function beforeSave($insert)
{
    if (parent::beforeSave($insert)) {
        // Convertir a mayúsculas los campos específicos
        $this->username = mb_strtoupper($this->username);
        // $this->apellido = mb_strtoupper($this->apellido);

        // Generar claves de autenticación
        if ($insert) {
            $this->authKey = Yii::$app->security->generateRandomString();
            $this->accesstoken = Yii::$app->security->generateRandomString();
        }

        // Encriptar contraseña
        if ($this->password) {
            $this->setPassword($this->password);
        }

        // Convertir roles a JSON si es un array y no es una creación
        if (!$insert && is_array($this->name)) {
            $this->name = json_encode($this->name);
        }

        return true;
    } else {
        return false;
    }
}

    public function afterFind()
    {
        parent::afterFind();
        if ($this->name) {
            $this->name = json_decode($this->name, true); // Decodificamos el JSON a un array
        }
    }


// Método de validación para verificar el estatus del personal antes de activar el usuario
public function validatePersonalBeforeActivating($attribute, $params)
{
    if ($this->id_estatus == 1) { // Si se intenta activar el usuario
        $personal = Personal::findOne(['ci' => $this->ci]);
        if ($personal && $personal->id_estatus != 1) { // Suponiendo que 1 es el estatus de ACTIVO
            $this->addError($attribute, 'Debe activar primero al personal antes de activar al usuario.');
        }
    }
}




    //Para invalidar las sesiones activas si se inicia una nueva. (Se llama en el SiteController)
    public function invalidatePreviousSessions()
    {
        Yii::$app->db->createCommand()
            ->delete('session', 'user_id = :user_id AND id != :session_id', [
                ':user_id' => $this->id,
                ':session_id' => Yii::$app->session->id,
            ])
            ->execute();
    }

    public function getDirtyAttributes($names = null)
    {
        $dirtyAttributes = parent::getDirtyAttributes($names);

        if (array_key_exists('name', $dirtyAttributes)) {
            $dirtyAttributes['name'] = json_encode($dirtyAttributes['name']);
        }

        // var_dump($dirtyAttributes);
        // exit;

        return $dirtyAttributes;
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
        return $this->hasOne(Personal::class, ['ci' => 'ci']);
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
        return $listRoles;
    } 

    public function getRoleList()
    {
        $auth = Yii::$app->authManager;
        $idUsu = Yii::$app->user->identity->id;
        $userRoles = $auth->getRolesByUser($idUsu);

        $list = [];
        foreach (self::getSystemRoles() as $role) {
            $list[$role] = $role;
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
        return static::findOne(['username' => $username, 'id_estatus' => 1]); // Solo usuarios activos
    }



    public function validatePassword($password)
    {
        return $this->id_estatus == 1 && Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    
}
