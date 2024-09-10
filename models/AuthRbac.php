<?php

namespace app\models;

use Yii;

class AuthRbac
{
    const PREFIX_ROLE = '[role]';
    const PREFIX_PERMISSION = '[perm]';

    /**
     * Obtiene el nombre del rol
     * @param string $itemName
     * @return string | NULL
     */
    public static function getRoleName($itemName)
    {
        return str_replace(self::PREFIX_ROLE, '', $itemName);
    }

    /**
     * Agrega el prefijo PREFIX_ROLE al nombre del rol
     * @param string $itemName
     * @return string
     */
    public static function setRoleName($itemName)
    {
        return self::PREFIX_ROLE . $itemName;
    }


    /**
     * Obtiene el nombre del modulo
     * @param string $itemName
     * @return string | NULL
     */
    public static function getModuleName($itemName)
    {
        $slices = explode('/', $itemName);
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
    public static function getControllerName($itemName)
    {
        $slices = explode('/', $itemName);
        $controller = null;
        if(count($slices) > 1){
            $controller = $slices[count($slices) - 2];
        }
        return $controller;
    }

    /**
     * Obtiene el nombre de la accion
     * @param string $itemName
     * @return string
     */
    public static function getActionName($itemName)
    {
        $action = $itemName;
        $slices = explode('/', $itemName);
        if(count($slices) >= 0){
            $action = $slices[count($slices) - 1];
        }
        return $action;
    }

    public static function getRoles()
    {
        $auth = Yii::$app->authManager;
        $roles = $auth->getRoles();
        // $roles debe transformarse en un array valido para ArrayDataProvider
        $aRoles = [];
        foreach ($roles as $key => $val) {
            $aRoles[] = $val;
        }
        return $aRoles;
    }

    public static function getPermissions()
    {
        $auth = Yii::$app->authManager;
        $permissions = $auth->getPermissions();
        // $permissions debe transformarse en un array valido para ArrayDataProvider
        $aPermissions = [];
        foreach ($permissions as $key => $val) {
            $aPermissions[] = $val;
        }
        return $aPermissions;
    }

    /**
     * [searchInArrayData description]
     * @param  array $data             List of roles
     * @param  array $searchAttributes search attributes
     * @return array                   List of roles by attributes
     */
    public static function searchInArrayData($data, $searchAttributes)
    {
        $result = [];

        $result = array_filter($data, function($item) use ($searchAttributes) {

            
                $conditions = [];
                foreach ($searchAttributes as $key => $value) {
                    if ($value) {
                        if(is_object($item)) {
                            $conditions[] = strlen($value) > 0 ? stripos('/^' . strtolower($item->$key) . '/', strtolower($value)) : true;
                        } else {
                            $conditions[] = strlen($value) > 0 ? stripos('/^' . strtolower($item[$key]) . '/', strtolower($value)) : true;
                        }
                    }
                }
                return array_product($conditions);
            
        });

        return $result;
    }

}
