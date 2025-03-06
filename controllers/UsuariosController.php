<?php

namespace app\controllers;
use Yii;
use app\models\Usuarios;
use app\models\UsuariosSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\AuthItem;
use yii\filters\AccessControl;
use yii\web\Response;
use app\models\Personal;

use yii\helpers\ArrayHelper;

/**
 * UsuariosController implements the CRUD actions for Usuarios model.
 */
class UsuariosController extends Controller
{
    /**
     * @inheritDoc
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
                        'view', 'index', 'create', 'update', 'delete', 'permisos',
                    ], 
                    'rules' => [
                        ['actions' => ['view'], 'allow' => true, 'roles' => ['usuarios/view']],
                        ['actions' => ['index'], 'allow' => true, 'roles' => ['usuarios/index']],
                        ['actions' => ['create'], 'allow' => true, 'roles' => ['usuarios/create']],
                        ['actions' => ['update'], 'allow' => true, 'roles' => ['usuarios/update']],
                        ['actions' => ['delete'], 'allow' => true, 'roles' => ['usuarios/delete']],
                        ['actions' => ['permisos'], 'allow' => true, 'roles' => ['usuarios/permisos']],
                    ]
                ]
            ]
        );
    }

    /**
     * Lists all Usuarios models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new UsuariosSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Usuarios model.
     * @param int $id_usuario Id Usuario
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_usuario)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_usuario),
        ]);
    }
    

    /**
     * Creates a new Usuarios model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Usuarios();
        $model->scenario = Usuarios::SCENARIO_CREATE;

        if ($model->load($this->request->post())) {
            // Verificar el estatus del personal antes de proceder
            $personal = Personal::findOne(['ci' => $model->ci]);
            if ($personal && $personal->id_estatus !== 1) { // Suponiendo que 1 es el estatus de ACTIVO
                Yii::$app->session->setFlash('error', 'El personal debe estar ACTIVO para poder crear un usuario.');
                return $this->render('create', [
                    'model' => $model,
                ]);
            }

            // Encriptar la contraseña
            if ($model->password) {
                $model->setPassword($model->password);
            }

            // Si la validación pasa, inicia una transacción
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if ($model->validate() && $model->save()) {
                    $auth = Yii::$app->authManager;
                    foreach ($model->name as $rol) { // Usar name directamente
                        $role = $auth->getRole($rol);
                        $auth->assign($role, $model->id_usuario);
                        
                    }
                    $transaction->commit();
                    Yii::$app->session->setFlash('success', 'Se ha creado exitosamente.');
                    return $this->redirect(['index', 'id_usuario' => $model->id_usuario]);
                } else {
                    $transaction->rollBack();
                    Yii::$app->session->setFlash('error', 'Error al guardar el usuario. Detalles del error: ' . json_encode($model->errors));
                }
            } catch (\Exception $e) {
                $transaction->rollBack();
                Yii::$app->session->setFlash('error', 'Error al guardar el usuario. Detalles del error: ' . $e->getMessage());
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }



    /**
     * Updates an existing Usuarios model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_usuario Id Usuario
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */

     /*public function actionUpdate($id_usuario)
     {
         $model = $this->findModel($id_usuario);
     
         // Selecciona roles del usuario y convierte a array para el formulario
         $model->name = $model->getUserRoles();
     
         if ($model->load($this->request->post())) {
             // Iniciar transacción
             $transaction = Yii::$app->db->beginTransaction();
             try {
                 // Verificar si hay roles seleccionados
                 if (is_array($model->name) && count($model->name) > 0) {
                     // Revocar todos los roles actuales
                     $auth = Yii::$app->authManager;
                     $auth->revokeAll($model->id_usuario);
     
                     // Asignar los nuevos roles
                     foreach ($model->name as $rol) {
                         $role = $auth->getRole($rol);
                         $auth->assign($role, $model->id_usuario);
                     }
     
                     if ($model->save()) {
                         $transaction->commit();
                         Yii::$app->session->setFlash('success', 'Actualización exitosa.');
                         return $this->redirect(['index', 'id_usuario' => $model->id_usuario]);
                     } else {
                         $transaction->rollBack();
                         Yii::$app->session->setFlash('error', 'Error al actualizar el usuario.');
                         return $this->render('update', ['model' => $model]);
                     }
                 } else {
                     $transaction->rollBack();
                     Yii::$app->session->setFlash('error', 'Debe seleccionar al menos un rol para el usuario.');
                     return $this->render('update', ['model' => $model]);
                 }
             } catch (yii\db\Exception $e) {
                 $transaction->rollBack();
                 Yii::error($e);
                 throw $e;
             }
         }
     
         return $this->render('update', [
             'model' => $model,
         ]);
    }*/

    public function actionUpdate($id_usuario)
    {
        $model = $this->findModel($id_usuario);

        // Verificar si el usuario tiene una sesión activa
        if ($model->session == 1) {
            Yii::$app->session->setFlash('error', 'No se puede editar un usuario con sesión activa.');
            return $this->redirect(['index']); // Redirigir a la lista de usuarios
        }

        // Selecciona roles del usuario y convierte a array para el formulario
        $model->name = $model->getUserRoles();

        if ($model->load($this->request->post())) {
            // Iniciar transacción
            $transaction = Yii::$app->db->beginTransaction();
            try {
                // Verificar si hay roles seleccionados
                if (is_array($model->name) && count($model->name) > 0) {
                    // Revocar todos los roles actuales
                    $auth = Yii::$app->authManager;
                    $auth->revokeAll($model->id_usuario);

                    // Asignar los nuevos roles
                    foreach ($model->name as $rol) {
                        $role = $auth->getRole($rol);
                        $auth->assign($role, $model->id_usuario);
                    }

                    if ($model->save()) {
                        $transaction->commit();
                        Yii::$app->session->setFlash('success', 'Actualización exitosa.');
                        return $this->redirect(['index', 'id_usuario' => $model->id_usuario]);
                    } else {
                        $transaction->rollBack();
                        Yii::$app->session->setFlash('error', 'Error al actualizar el usuario.');
                        return $this->render('update', ['model' => $model]);
                    }
                } else {
                    $transaction->rollBack();
                    Yii::$app->session->setFlash('error', 'Debe seleccionar al menos un rol para el usuario.');
                    return $this->render('update', ['model' => $model]);
                }
            } catch (yii\db\Exception $e) {
                $transaction->rollBack();
                Yii::error($e);
                throw $e;
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
     

     



    /**
     * Deletes an existing Usuarios model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_usuario Id Usuario
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_usuario)
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            // Intentar eliminar (lógicamente) el usuario
            $model = $this->findModel($id_usuario);
            $model->id_estatus = 2; // Eliminación lógica: cambiar el estado a inactivo

            if (!$model->save(false)) {
                throw new \yii\db\Exception('No se pudo desactivar el usuario.');
            }

            $transaction->commit();
            Yii::$app->session->setFlash('success', 'Se ha desactivado correctamente.');
        } catch (\yii\db\IntegrityException $e) {
            $transaction->rollBack();
            Yii::$app->session->setFlash('error', 'Usuario posee una sesión activa, por favor cierre sesión antes de desactivarlo.');
        } catch (\Exception $e) {
            $transaction->rollBack();
            Yii::$app->session->setFlash('error', 'Error al desactivar el usuario: ' . $e->getMessage());
        }

        return $this->redirect(['index']);
    }



    public function actionToggleStatus($id_usuario)
    {
        $model = $this->findModel($id_usuario);

        if ($model->id_estatus == 2) { // Si se intenta activar el usuario
            $personal = Personal::findOne(['ci' => $model->ci]);
            if ($personal && $personal->id_estatus != 1) { // Suponiendo que 1 es el estatus de ACTIVO
                Yii::$app->session->setFlash('error', 'Debe activar primero al personal antes de activar al usuario.');
                return $this->redirect(['index']);
            }
        }

        if ($model->id_estatus == 1) {
            $model->id_estatus = 2; // Desactivar
            Yii::$app->session->setFlash('success', 'Se ha desactivado correctamente.');
        } else {
            $model->id_estatus = 1; // Activar
            Yii::$app->session->setFlash('success', 'Se ha activado correctamente.');
        }

        $model->save(false); // Guardar sin validar
        return $this->redirect(['index']);
    }



    /**
     * Finds the Usuarios model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_usuario Id Usuario
     * @return Usuarios the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_usuario)
    {
        if (($model = Usuarios::findOne(['id_usuario' => $id_usuario])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    //Funcion paravalidar la cedula en el campo de busqueda del formulario.
    public function actionValidarCedula()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            $cedula = Yii::$app->request->post('search');

            // Validación básica de la cédula (puedes agregar más validaciones)
            if (!is_numeric($cedula)) {
                return ['error' => 'La cédula debe ser un número'];
            }

            $modelPersonal = new Personal();
            $datosPersona = $modelPersonal->buscarInformacionPersona($cedula);

            if ($datosPersona) {
                return $datosPersona;
            } else {
                return ['error' => 'Datos no encontrados. Por favor, registre al personal.'];
            }
        }
    }
}