<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
                'access' => [
                    'class' => AccessControl::class,
                    'only' => [
                        'index', 'create', 'update', 'delete', 'permisos',
                    ], 
                    'rules' => [
                        ['actions' => ['index'], 'allow' => true, 'roles' => ['@']],
                        // ['actions' => ['create'], 'allow' => true, 'roles' => ['@']],
                        // ['actions' => ['update'], 'allow' => true, 'roles' => ['@']],
                        // ['actions' => ['delete'], 'allow' => true, 'roles' => ['@']],
                        // ['actions' => ['permisos'], 'allow' => true, 'roles' => ['@']],
                    ]
                ]
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    // public function actions()
    // {
    //     return [
    //         'error' => [
    //             'class' => 'yii\web\ErrorAction',
    //         ],
    //         'captcha' => [
    //             'class' => 'yii\captcha\CaptchaAction',
    //             'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
    //         ],
    //     ];
    // }

    public function actionError()
    {
        $exception = Yii::$app->errorHandler->exception;
        if ($exception !== null) {
            if ($exception->statusCode === 403) {
                return $this->render('error', ['name' => 'Permiso Denegado', 'message' => 'No tiene los permisos suficientes para esta acción.']);
            }
            return $this->render('error', ['name' => 'Error', 'message' => $exception->getMessage()]);
        }
    }
    


    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        // Iniciar la sesión
        Yii::$app->session->open();

        // Establecer un valor en la sesión
        Yii::$app->session->set('myKey', 'myValue');

        // Obtener un valor de la sesión
        $value = Yii::$app->session->get('myKey');

        // Verificar si la sesión ha expirado
        if (Yii::$app->session->isActive) {
            // La sesión está activa
        } else {
            // La sesión ha expirado
        }

        // Resto del código
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        //Para agregar un layout al login y que no muestre la barra de menu. Antes hay que crear el archivo,
        //en este caso loginlayout.php dentro de la carpeta layouts que se encuentra en la varpeta views
        $this->layout = 'loginlayout';

        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            Yii::$app->user->identity->invalidatePreviousSessions(); // Llamar a la función para invalidar sesiones anteriores
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
