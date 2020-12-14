<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\PedidoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pedidos Realizados';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pedido-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            ['attribute'=>'Nro Pedido',
             'value'=> 'idPedido'],
            ['attribute'=>'Producto',
             'value'=> 'producto.nombre'],
             ['attribute'=>'Estado',
             'value'=> 'estado.nombre'],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{ver}',
                'header' => '',
                'buttons'=>[
                    'ver' => function ($url, $model) {     
                          return Html::a('<span class="glyphicon glyphicon-search"></span>', $url, [
                              'title' => Yii::t('yii', 'Ver Pedido'),
                          ]);                                
                      },
                  ],
                'urlCreator' => function ($action, $model, $key, $index) {
                                if ($action === 'ver') {
                                    $url =Url::to(['carrito/checkout?idPedido='.$model->idPedido]);
                                    return $url;
                                }
                }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
