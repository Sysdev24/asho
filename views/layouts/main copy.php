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
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
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
        <div class="col-md-12"><img src="<?= yii::getAlias('@web')?>/img/banner_superior.png" alt="banner superior" class="img-fluid"></div>
    </div>

    <?php
    NavBar::begin([
        //'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => ['class' => 'navbar-expand-md navbar-dark bg-dark fixed-top']

    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav'],
        'items' => [
                //['label' => 'Inicio', 'url' => ['/site/index']],
                //['label' => 'About', 'url' => ['/site/about']],
                //['label' => 'Contact', 'url' => ['/site/contact']],
                ['label' => 'Afectacion Persona', 'url' => ['/afectacionpersona/index']],
                ['label' => 'Estados', 'url' => ['/estados/index']],
                ['label' => 'Estatus', 'url' => ['/estatus/index']],
                ['label' => 'Gerencia', 'url' => ['/gerencia/index']],
                ['label' => 'Magnitud', 'url' => ['/magnitud/index']],
                ['label' => 'Personal', 'url' => ['/personal/index']],
                ['label' => 'Regiones', 'url' => ['/regiones/index']],
                ['label' => 'Roles', 'url' => ['/roles/index']],
                ['label' => 'Naturaleza Accidentes', 'url' => ['/naturalezaaccidente/index']],
                ['label' => 'Cargo', 'url' => ['/cargo/index']],
                ['label' => 'Clasificacion Incidente', 'url' => ['/clasificacionincidente/index']],
                ['label' => 'Sujeto Afectacion', 'url' => ['/sujetoafectacion/index']],
                ['label' => 'Tipo Accidente', 'url' => ['/tipoaccidente/index']],
                ['label' => 'Tipo Trabajo', 'url' => ['/tipotrabajo/index']],
                ['label' => 'Usuarios', 'url' => ['/usuarios/index']],
                ['label' => 'Afectacion Bienes Procesos', 'url' => ['/afectacionbienesprocesos/index']],
                //['label' => 'Peligro Agente', 'url' => ['/peligroagente/index']],
                ['label' => 'Clasificacion Accidente', 'url' => ['/clasificacionaccidente/index']],

                Yii::$app->user->isGuest
                    ? ['label' => 'Login', 'url' => ['/site/login']]
                    : '<li class="nav-item">'
                        . Html::beginForm(['/site/logout'])
                        . Html::submitButton(
                            'Logout (' . Yii::$app->user->identity->username . ')',
                            ['class' => 'nav-link btn btn-link logout']
                        )
                        . Html::endForm()
                        . '</li>'
            ]
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
