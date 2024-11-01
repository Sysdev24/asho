<?php
namespace app\models;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

class AsigRolesPermisosForm extends Model
{
    public $name;
    public $roles;
    public $rolesOld;
    public $permisos;
    public $permisosOld;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'type'], 'required'],
            ['name', 'trim'],
            ['name', 'match', 'pattern' => '/^[a-z|0-9|\/-]*$/'],
            [['name'], 'string', 'max' => 64],

            ['roles', 'each', 'rule' => ['string']],
        	['roles', 'in', 'range' => self::getSystemRoles(), 'allowArray' => true],

            ['rolesOld', 'each', 'rule' => ['string']],
        	['rolesOld', 'in', 'range' => self::getSystemRoles(), 'allowArray' => true],

            ['permisos', 'each', 'rule' => ['string']],
        	['permisos', 'in', 'range' => self::getSystemPermisos(), 'allowArray' => true],

            ['permisosOld', 'each', 'rule' => ['string']],
        	['permisosOld', 'in', 'range' => self::getSystemPermisos(), 'allowArray' => true],

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
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('app', 'Nombre del rol'),
            'roles' => Yii::t('app', 'Roles'),
            'permisos' => Yii::t('app', 'Permisos'),
        ];
    }


    public function setRoles($id) 
    {
        $auth = Yii::$app->authManager;
        $roles = $auth->getChildRoles($id);
        $roles = ArrayHelper::getColumn($roles, 'name');

        $this->roles = [];
        $this->rolesOld = [];

        if (count($roles) > 0) {
            foreach ($roles as $rol) {
                if ($rol != $this->name) {
                    $this->roles[] = $rol;
                    $this->rolesOld[] = $rol;
                }
            }
        }
    }


    public function setPermisos($id) 
    {
        $auth = Yii::$app->authManager;
        $permisos = $auth->getPermissionsByRole($id);
        $this->permisos = ArrayHelper::getColumn($permisos, 'name');
        $this->permisosOld = [];
        $this->permisosOld = ArrayHelper::getColumn($permisos, 'name');
    }


    public function getSystemRoles($conDescripcion = false, $removeRol = false)
    {
        $auth = Yii::$app->authManager;
    	$roles = $auth->getRoles();
        $list = [];
        foreach ($roles as $rol) {
            if ($removeRol != $rol->name) {
                if ($conDescripcion) {
                    $list[$rol->name] = $rol->name . ' - ' . $rol->description;
                } else {
                    $list[] = $rol->name;
                }
            }
        }
        return $list;
    }


    public function getSystemPermisos($conDescripcion = false)
    {
        $auth = Yii::$app->authManager;
    	$permisos = $auth->getPermissions();
        $list = [];
        foreach ($permisos as $permiso) {
            if ($conDescripcion) {
                $list[$permiso->name] = $permiso->name . ' - ' . $permiso->description;
            } else {
                $list[] = $permiso->name;
            }
        }
        return $list;
    }

    
    public function itemsSeleccionados($anterior, $nuevo)
    {
        $seleccionados = [];
        if ($nuevo && count($nuevo) > 0) {
            foreach ($nuevo as $item) {
                if ($anterior) {
                    if (!in_array($item, $anterior)) {
                        $seleccionados[] = $item;
                    }
                } else {
                    $seleccionados[] = $item;
                }
            }
        }
        return $seleccionados;
    }

    public function itemsDeseleccionados($anterior, $nuevo)
    {
        $eliminados = [];
        if ($anterior && count($anterior) > 0) {
            foreach ($anterior as $item) {
                if ($nuevo) {
                    if (!in_array($item, $nuevo)) {
                        $eliminados[] = $item;
                    }
                } else {
                    $eliminados[] = $item;
                }
            }
        }
        return $eliminados;
    }

    public function save()
    {
        $auth = Yii::$app->authManager;
        try {
            
            $rolesSelec = $this->itemsSeleccionados($this->rolesOld, $this->roles);
            $rolesDeselec = $this->itemsDeseleccionados($this->rolesOld, $this->roles);
            $permisosSelec = $this->itemsSeleccionados($this->permisosOld, $this->permisos);
            $permisosDeselec = $this->itemsDeseleccionados($this->permisosOld, $this->permisos);

            // ROLES
            if( count($rolesSelec) > 0 ) {
                foreach ($rolesSelec as $itemSelec) {
                    $item = $auth->getRole($itemSelec);
                    if(isset($item)){
                        $auth->addChild($auth->getRole($this->name), $item);
                    }
                }
            }
            if( count($rolesDeselec) > 0 ) {
                foreach ($rolesDeselec as $itemDeselec) {
                    $item = $auth->getRole($itemDeselec);
                    if(isset($item)){
                        $auth->removeChild($auth->getRole($this->name), $item);
                    }
                }
            }

            // PERMISOS
            if( count($permisosSelec) > 0 ) {
                foreach ($permisosSelec as $itemSelec) {
                    $item = $auth->getPermission($itemSelec);
                    if(isset($item)){
                        $auth->addChild($auth->getRole($this->name), $item);
                    }
                }
            }
            if( count($permisosDeselec) > 0 ) {
                foreach ($permisosDeselec as $itemDeselec) {
                    $item = $auth->getPermission($itemDeselec);
                    if(isset($item)){
                        $auth->removeChild($auth->getRole($this->name), $item);
                    }
                }
            }
            return false;

        } catch (\Throwable $th) {
            return 'Error al intentar guardar roles';
        }
    }
}
