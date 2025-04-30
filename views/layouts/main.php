<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/Corpoelec-logo.ico')]);

//Js de menu
$this->registerJsFile('@web/js/scripts.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js', ['position' => \yii\web\View::POS_HEAD]); 
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header id="header">
    <!-- Para poner el banner -->
    <div class="row">
        <div class="col-md-12"><img src="<?= yii::getAlias('@web')?>/img/cintillo-superior2.png" alt="banner superior" class="img-fluid"></div>
    </div>

    <?php
    NavBar::begin([
        //'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => ['class' => 'navbar-expand-md navbar-dark bg-dark'],
        //'options' => ['class' => 'navbar-expand-md navbar-dark bg-dark fixed-top'],
    ]);
    
    $adminItems = array_filter([
        Yii::$app->user->can('tipacccategoria/index') ? ['label' => 'Tipo Accidente', 'url' => ['/tipacccategoria/index']] : false,

        Yii::$app->user->can('tipotrabajo/index') ? ['label' => 'Tipo Trabajo', 'url' => ['/tipotrabajo/index']] : false,

        Yii::$app->user->can('peliagencategoria/index') ? ['label' => 'Peligro Agente', 'url' => ['/peliagencategoria/index']] : false,

        Yii::$app->user->can('exposicioncontaccategoria/index') ? ['label' => 'Exposicion o contacto', 'url' => ['/exposicioncontaccategoria/index']] : false,

        Yii::$app->user->can('magnitud/index') ? ['label' => 'Magnitud', 'url' => ['/magnitud/index']] : false,

        Yii::$app->user->can('sujeafeccategoria/index') ? ['label' => 'Sujeto afectación', 'url' => ['/sujeafeccategoria/index']] : false,

        Yii::$app->user->can('naturalezaaccidente/index') ? ['label' => 'Naturaleza Accidentes', 'url' => ['/naturalezaaccidente/index']] : false,

        Yii::$app->user->can('gerencia/index') ? ['label' => 'Gerencia y Procesos', 'url' => ['/gerencia/index']] : false,

        Yii::$app->user->can('afecpercategoria/index') ? ['label' => 'Afectacion Persona', 'url' => ['/afecpercategoria/index']] : false,

        Yii::$app->user->can('estados/index') ? ['label' => 'Estados', 'url' => ['/estados/index']] : false,

        Yii::$app->user->can('personal/index') ? ['label' => 'Personal', 'url' => ['/personal/index']] : false,

        Yii::$app->user->can('personanatural/index') ? ['label' => 'Persona Natural', 'url' => ['/personanatural/index']] : false,

        Yii::$app->user->can('roles/index') ? ['label' => 'Roles', 'url' => ['/roles/index']] : false,

        Yii::$app->user->can('usuarios/index') ? ['label' => 'Usuarios', 'url' => ['/usuarios/index']] : false,

        //Yii::$app->user->can('cargo/index') ? ['label' => 'Cargo', 'url' => ['/cargo/index']] : false,

        // Yii::$app->user->can('causainmediatadirectas/index') ? ['label' => 'Causa Inmediata Directas', 'url' => ['/causainmediatadirectas/index']] : false,

        //Yii::$app->user->can('clasificacionaccidente/index') ? ['label' => 'Clasificacion Accidente', 'url' => ['/clasificacionaccidente/index']] : false,

        // Yii::$app->user->can('causascb/index') ? ['label' => 'Causa Cb', 'url' => ['/causascb/index']] : false,

        //Yii::$app->user->can('estatus/index') ? ['label' => 'Estatus', 'url' => ['/estatus/index']] : false,

        // Yii::$app->user->can('evaluacionpotencialperdida/index') ? ['label' => 'Evaluacion Potencial Perdida', 'url' => ['/evaluacionpotencialperdida/index']] : false,

        // Yii::$app->user->can('permisos/index') ? ['label' => 'Permisos', 'url' => ['/permisos/index']] : false,

        //Yii::$app->user->can('regiones/index') ? ['label' => 'Regiones', 'url' => ['/regiones/index']] : false,

        // Yii::$app->user->can('reglaoro/index') ? ['label' => 'Regla Oro', 'url' => ['/reglaoro/index']] : false,

        //Yii::$app->user->can('severidadpotencialperdida/index') ? ['label' => 'Severidad Potencial Perdida', 'url' => ['/severidadpotencialperdida/index']] : false,


        // Yii::$app->user->can('tipocontacto/index') ? ['label' => 'Tipo Contacto', 'url' => ['/tipocontacto/index']] : false,
        
    ]);

    $registerItems = array_filter([
        Yii::$app->user->can('registro/index') ? ['label' => 'Registro', 'url' => ['/registro/index']] : false,
        // Yii::$app->user->can('registroreglaoro/index') ? ['label' => 'Registro Regla de Oro', 'url' => ['/registroreglaoro/index']] : false,
    ]);
    
    $menuItems = [];
    
    if (!empty($adminItems)) {
        $menuItems[] = [
            'label' => 'Administración',
            'items' => $adminItems,
        ];
    }

    if (!empty($registerItems)) {
        $menuItems[] = [
            'label' => 'Registrar',
            'items' => $registerItems,
        ];
    }

    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Iniciar Sesión', 'url' => ['/site/login']];
    } else {
        $menuItems[] = '<li class="nav-item">'
            . Html::beginForm(['/site/logout'])
            . Html::submitButton(
                'Salir (' . Yii::$app->user->identity->username . ')',
                ['class' => 'nav-link btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';
    }

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav'],
        'items' => $menuItems,
    ]);

    NavBar::end();
    ?>
</header>

<main id="main" class="flex-shrink-0" role="main">
    <div class="container">
        <?php if (!empty($this->params['breadcrumbs'])): ?>
            <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
        <?php endif ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>

<footer id="footer" class="mt-auto py-3 bg-light">
    <div class="container">
        <div class="row text-muted">
            <div class="col-md-6 text-center text-md-start">&copy; Corpoelec <?= date('Y') ?></div>
        </div>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
