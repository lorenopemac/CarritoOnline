<?php
use yii\helpers\Url;
/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Bienvenido!</h1>

        <a class="btn btn-success" href="<?=Url::to(['catalogo/catalogo']); ?>"><h3>Vea nuestro catálogo</h3></a>
    </div>

    <div class="body-content">

    </div>
</div>
