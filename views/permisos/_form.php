<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Estatus;

/** @var yii\web\View $this */
/** @var app\models\Roles $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="roles-form">

    <?php if ($errorMessage) : ?>
        <div class="alert alert-danger d-flex align-items-center alert-dismissible fade show my-4" role="alert">
            <i class="fa-solid fa-triangle-exclamation fa-2xl me-3"></i>
            <strong class="me-2">Error!</strong><?= $errorMessage ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput() ?>
    
    <?= $form->field($model, 'description')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>

        <?= Html::a(
            '<i class="fas fa-reply me-1"></i> ' . Yii::t('app', 'Atrás'),
            Yii::$app->request->referrer, ['class'=>'btn btn-secondary']
        ) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
