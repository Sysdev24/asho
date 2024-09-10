<?php

namespace app\commands;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        // Eliminar todos los datos previos
        $auth->removeAll();

        // Crear permisos
        $createPost = $auth->createPermission('createPost');
        $createPost->description = 'Crear un post';
        $auth->add($createPost);

        $updatePost = $auth->createPermission('updatePost');
        $updatePost->description = 'Actualizar un post';
        $auth->add($updatePost);

        // Crear roles
        $author = $auth->createRole('author');
        $auth->add($author);
        $auth->addChild($author, $createPost);

        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $updatePost);
        $auth->addChild($admin, $author);

        echo "RBAC inicializado correctamente.\n";
    }
}