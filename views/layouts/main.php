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
    $menuItems = [
        [
            'label' => 'Administración',
        'items' => [

                ['label' => 'Afectacion Persona', 'url' => ['/afecpercategoria/index']], 

                ['label' => 'Cargo', 'url' => ['/cargo/index']],

                // ['label' => 'Causa Inmediata Directas', 'url' => ['/causainmediatadirectas/index']],

                ['label' => 'Clasificacion Accidente', 'url' => ['/clasificacionaccidente/index']],

                // ['label' => 'Causa Cb', 'url' => ['/causascb/index']],


                ['label' => 'Estados', 'url' => ['/estados/index']],

                ['label' => 'Estatus', 'url' => ['/estatus/index']],

                ['label' => 'Evaluacion Potencial Perdida', 'url' => ['/evaluacionpotencialperdida/index']],

                ['label' => 'Gerencia', 'url' => ['/gerencia/index']],

                ['label' => 'Magnitud', 'url' => ['/magnitud/index']],

                ['label' => 'Naturaleza Accidentes', 'url' => ['/naturalezaaccidente/index']],

                ['label' => 'Peligro Agente', 'url' => ['/peliagencategoria/index']],

                ['label' => 'Permisos', 'url' => ['permisos/index']],

                ['label' => 'Personal', 'url' => ['/personal/index']],

                ['label' => 'Persona Natural', 'url' => ['/personanatural/index']],

                ['label' => 'Regiones', 'url' => ['/regiones/index']],

                // ['label' => 'Regla Oro', 'url' => ['/reglaoro/index']],

                ['label' => 'Roles', 'url' => ['/roles/index']],

                ['label' => 'Severidad Potencial Perdida', 'url' => ['/severidadpotencialperdida/index']],
                
                ['label' => 'Sujeto afectación', 'url' => ['/sujeafeccategoria/index']],

                ['label' => 'Tipo Accidente', 'url' => ['/tipacccategoria/index']],

                // ['label' => 'Tipo Contacto', 'url' => ['/tipocontacto/index']],

                ['label' => 'Tipo Trabajo', 'url' => ['/tipotrabajo/index']],
                
                ['label' => 'Usuarios', 'url' => ['/usuarios/index']],
                
            ],

        ],
        [
            'label' => 'Registrar',
            'items' => [

                ['label' => 'Registro', 'url' => ['/registro/index']],

                // ['label' => 'Registro Regla de Oro', 'url' => ['/registroreglaoro/index']],
            ],
        ]
    ];

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

