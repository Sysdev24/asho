<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'RPI',
    'name' => 'Sistema de RPI',
    'basePath' => dirname(__DIR__),
    'language' => 'es',
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'kHYMWNlZSkWWatFC-ydqCHEP-XwVHy1L',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
           // 'identityClass' => 'app\models\User',
            'identityClass' => 'app\models\Usuarios',
            'enableAutoLogin' => true,
            'loginUrl' => ['site/login'],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@app/mail',
            // send all mails to a file by default.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
            ],

        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        
        'db' => $db,
        
       /** 'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],*/

        /**'defaultRoute' => 'site/login',*/
        

        'assetManager' => [
            'bundles' => [
                // ...
            ],
            'basePath' => '@app/web/assets', // Asegúrate de que esta sea la ruta correcta a tu directorio widgets
        ],
        
    ],
        
        'as access' => [
    'class' => \yii\filters\AccessControl::className(),
    'rules' => [
        [
            'actions' => ['login', 'error'],
            'allow' => true,
        ],
        [
            'actions' => ['logout', 'index', 'view', 'create', 'update', 'delete', 'area', 'naturaleza',
                            'create-area', 'create-naturaleza', 'update-area', 'update-naturaleza',
                            'delete-area', 'delete-naturaleza'], // Agrega todas las acciones que requieren autenticación
            'allow' => true,
            'roles' => ['@'], // Requiere que el usuario esté autenticado
        ],
    ],
    'except' => ['debug/*'], // Excluye el módulo de debug de las reglas de acceso
    ],
        

    'params' => $params,
];

if (YII_ENV_DEV) {

        // configuración de módulos ajustada para el entorno 'dev'
        $config['bootstrap'][] = 'debug';
        $config['modules']['debug'] = [
            'class' => 'yii\debug\Module',
        ];


    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
    
}

return $config;
