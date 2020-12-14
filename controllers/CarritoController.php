<?php

namespace app\controllers;

use Yii;
use app\models\Producto;
use app\models\Pedido;
use app\models\Estado;
use app\models\ProductoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\vendor\webservice\Webservice;
use yii\rest\ActiveController;
/**
 * CarritoController .
 */
class CarritoController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Vista de un pedido  y posiblidad de pago o cancelación
     * @param integer $idProducto
     * @param integer $idPedido
     * @return mixed
     */
    public function actionCheckout($idProducto=0,$idPedido=0)
    {
        $falla = false;//se utiliza para mostrar un mensaje de fallo en el checkout
        if($idPedido == 0){
            /**En el caso de una nueva compra */
            $producto = Producto::find()->where(['idProducto' => $idProducto])->one();
            $pedido = new Pedido();
            $pedido->idEstado = 1; //nuevo
            $pedido->idProducto = $idProducto; 
            $pedido->idUsuario = 1; //dummy
            $pedido->fechaCreacion = date("Y-m-d H:i:s"); 
            $pedido->save();
        }else{
            /**En el caso de una compra que ya se realizo y esta en proceso o finalizada */
            $request = Yii::$app->request;
            $estado =  $request->get('status');//estado retornado luego del checkout
            $idTransaccion = $request->get('transactionId');//id de la transacción
            $type = $request->get('type');//tipo de pago
            $pedido = Pedido::find()->where(['idPedido' => $idPedido])->one();
            $producto = Producto::find()->where(['idProducto' => $pedido->idProducto])->one();
            if($type == 'none'){
                //fallo el pago
                $falla = true;
            }else{
                //pago en proceso o pagado
                $nuevoEstado =Estado::find()->where(['idEstado' => $this->estadoPedido($estado,$type)])->one();  
                $viejoEstado =Estado::find()->where(['idEstado' => $pedido->idEstado])->one();  
                //solo si el orden es mayor o igual se cambia de estado
                if($nuevoEstado->orden >= $viejoEstado->orden){
                    $pedido->idEstado = $nuevoEstado->idEstado;
                }
                $pedido->transactionId = $idTransaccion;// se podria utilizar en el futuro para rastrear el pago
                $pedido->save();
            }
        }
        
        return $this->render('checkout', [
            'producto' => $producto,
            'pedido' => $pedido,
            'falla' => $falla,
        ]);
    }

    /**
     * Retorna el estado que debe tener un pedido según estado retornado
     * @param integer $estado
     * @param String $type
     * @return integer
     */
    private function estadoPedido($estado,$type){
        $nuevoEstado = 1;//estado default nuevo
        /**Si el type no es none entonces se realizo un avance en la transacción */
        if($type != 'none'){
            if(($estado > 1 && $estado < 200) || ($estado > 298 && $estado < 304)){
                /** En estado pendiente */
                $nuevoEstado = 2;            
            }else{
                if($estado > 199 && $estado < 304){
                    /** En estado pagado */
                    $nuevoEstado = 3;        
                }else{
                    if($estado > 399 && $estado < 800){
                        /** En estado cancelada */
                        $nuevoEstado = 4;        
                    }
                }
            }
        }
        return $nuevoEstado;
    }


    /**
     * Lists all Producto models.
     * @return mixed
     */
    public function actionPago($idPedido)
    {

        $url = Yii::getAlias('@urlSSH');//URL definida en config/web.php

        $pedido = Pedido::find()->where(['idPedido' => $idPedido])->one();
        $producto = Producto::find()->where(['idProducto' => $pedido->idProducto])->one();
        //Se genera un array-body del request como un Form
        $arrForm = 
        [
            "total" => $producto->precio,
            "currency" => "ARS",
            "reference" => $pedido->idPedido,
            "description" => "Venta de producto",
            "items" => '[{
                "image": "https://dalealaweb.com/wp-content/uploads/2016/08/necesidad-usp-marketing-digital.jpg",
                "quantity": 1,
                "description":'.$producto->nombre.',
                "total": 1 }]',
            "webhook" => $url."/webhook/estadopedido?idPedido=".$pedido->idPedido,
            "redirect" => "true",
            "return_url" => $url."/carrito/checkout?idPedido=".$pedido->idPedido
        ]; 

        $resultadoArray = Webservice::llamadaPago($arrForm);
        $urlRetorno = 'catalogo/catalogo';//En caso de fallo se lo redirige al catalogo
        if($resultadoArray[0]==1){// si retorna result = 1
            $pedido->urlPago = $resultadoArray[1];
            $pedido->save();
            $urlRetorno = $resultadoArray[1];
        }
        return $this->redirect(''.$urlRetorno.'');
    }

    


    /**
     * Elimina un pedido.
     * Se deberia enviar un mensaje al checkout para avisar de la cancelación del cupón
     * @param idPedido 
     * @return mixed
     */
    public function actionEliminarpedido($idPedido)
    {
        $pedido = Pedido::find()->where(['idPedido' => $idPedido])->one();
        $pedido->baja = 1;
        $pedido->save();

        return $this->redirect(['catalogo/catalogo']);
    }

}
