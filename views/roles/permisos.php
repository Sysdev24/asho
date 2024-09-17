<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var app\models\Roles $model */

$this->title = 'Agregar permisos a rol ' . $model->name;

?>
<div class="roles-permisos">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if ($errorMessage) : ?>
        <div class="alert alert-danger d-flex align-items-center alert-dismissible fade show my-4" role="alert">
            <i class="fa-solid fa-triangle-exclamation fa-2xl me-3"></i>
            <strong class="me-2">Error!</strong><?= $errorMessage ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php $form = ActiveForm::begin([
        'class' => 'form-vertical',    
    ]); ?>


        <div class="row my-4">
            <div class="col-12 col-md-6">
                <div class="card">
                    <div class="card-header py-3">
                        <h4>Permisos</h4>
                    </div>
                    <div class="card-body">
                        <?= $form->field($model, 'permisos', [
                            'template' => "<div>{input}\n{error}</div>",
                        ])->checkboxList($model->getSystemPermisos(true), [
                            'itemOptions' => [
                                'labelOptions' => ['class' => 'custom-control-label w-100 my-1'],
                                'wrapperOptions' => ['class'=>'form-check'],
                            ],
                        ]) ?>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6">
                <div class="card">
                <div class="card-header py-3">
                        <h4>Roles</h4>
                    </div>
                    <div class="card-body">
                        <?= $form->field($model, 'roles', [
                            'template' => "<div>{input}\n{error}</div>",
                        ])->checkboxList($model->getSystemRoles(true, $model->name), [
                            'itemOptions' => [
                                'labelOptions' => ['class' => 'custom-control-label w-100 my-1'],
                                'wrapperOptions' => ['class'=>'form-check'],
                            ],
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>


    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>

        <?= Html::a(
            '<i class="fas fa-reply me-1"></i> ' . Yii::t('app', 'Atrás'),
            Yii::$app->request->referrer, ['class'=>'btn btn-secondary']
        ) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
