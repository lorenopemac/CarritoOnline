<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Pedido */

$this->title = 'Pedido N°: '.$model->idPedido;
$this->params['breadcrumbs'][] = ['label' => 'Pedidos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="pedido-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [                      // the owner name of the model
                'label' => 'Nombre ',
                'value' => $model->producto->nombre,
            ],
            [                      // the owner name of the model
                'label' => 'Precio $ ',
                'value' => $model->producto->precio,
            ],
            [                      // the owner name of the model
                'label' => 'Estado del pedido ',
                'value' => $model->estado->nombre,
            ],
        ],
    ]) ?>


</div>
