<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

$this->title = 'Finalizar Compra';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>

.producto {
    border: 2px outset rgba(28,110,164,0.11);
    border-radius: 6px;
}

.card {
  /
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
  max-width: 500px;
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

</style>

<div class="producto-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <!-- Alerta en caso de fallar el pago-->
    <?php if($falla){ ?>      
      <div class="alert alert-danger" role="alert">
        Fallo el proceso de pago, vuelva a intentarlo nuevamente en unos minutos.
      </div>
    <?php } ?>      
    <!-- Dato del producto y el pedido-->
    <div class="producto">
            <div class="col-md-6 col-xs-12  jumbotron">
                <p>  <img src="https://dalealaweb.com/wp-content/uploads/2016/08/necesidad-usp-marketing-digital.jpg" alt="Italian Trulli"> </p>
                <p></p><b><h3>Producto</h3> <h4 style="height:50px; text-align:center"><?= $producto->nombre ?></h4></b> <p></p>
                <p></p><b><h3>Precio</h3> <h4 style="height:50px;"><?= $producto->precio ?></h4></b> <p></p>
            </div>
            <!-- Info del pedido-->
            <div class="col-md-6 col-xs-12  jumbotron">
              <p></p><b><h3>Pedido Numero: </h3> <h4 style="height:50px;"><?= $pedido->idPedido ?></h4></b> <p></p>
              <p></p><b><h3>Estado: </h3> <h4 style="height:50px;"><?= $pedido->estado->nombre ?></h4></b> <p></p>
              <?php if($pedido->idEstado == 1){ ?>      
                <!-- Solo se puede pagar si el estado es "nuevo" -->
                <?= Html::a('Finalizar Compra', ['/carrito/pago','idPedido'=> $pedido->idPedido], ['class'=>'btn btn-success']) ?>
              <?php } ?>      
              <?= Html::a('Eliminar Compra', ['/carrito/eliminarpedido','idPedido'=> $pedido->idPedido], ['class'=>'btn btn-danger'
                ,'data' => [
                  'confirm' => 'Quiere cancelar la compra?',
                  'method' => 'post',
                ],
              ]) ?>
            </div>
    </div>


</div>
