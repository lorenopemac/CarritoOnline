<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ProductoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Productos a la venta';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>

.producto {
    border: 2px outset rgba(28,110,164,0.11);
    border-radius: 6px;
}

.card {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
  max-width: 350px;
  margin: auto;
  text-align: center;
  font-family: arial;
  margin-top: 10.5px;
}

.price {
  color: grey;
  font-size: 22px;
}

.card button {
  border: none;
  outline: 0;
  padding: 12px;
  color: white;
  background-color: #4CAF50;
  text-align: center;
  cursor: pointer;
  width: 100%;
  font-size: 18px;
}

.card button:hover {
  opacity: 0.7;
}

.btn{
  width:100%;
}
</style>

<div class="producto-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="productos">
        <?php foreach($productos as $producto):?>
            <div class="col-lg-4 card">
                <p>  <img src="https://dalealaweb.com/wp-content/uploads/2016/08/necesidad-usp-marketing-digital.jpg" alt="Italian Trulli"> </p>
                <p></p><b> <h4 style="height:50px; text-align:center"><?= $producto->nombre ?></h4></b> <p></p>
                <p></p><b> <h4 style="height:50px;">$ <?= $producto->precio ?></h4></b> <p></p>
                
                <a class="btn btn-success" href="<?=Url::to(['carrito/checkout', 'idProducto'=>$producto->idProducto]); ?>"><h3>Comprar</h3></a>
            </div>
        <?php endforeach; ?>
    </div>


</div>
