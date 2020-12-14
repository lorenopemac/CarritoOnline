<?php

namespace app\controllers;
use app\models\Pedido;
use yii\rest\ActiveController;

class WebhookController extends ActiveController
{
    public $modelClass = 'app\models\Pedido';

    /**
     * Webhook que recibe cambios en el estado de un pedido
     * @param integer $idPedido
     * @return mixed
     */
    public function actionEstadopedido($idPedido){
        $this->enableCsrfValidation = false;
        header('Content-Type: application/x-www-form-urlencoded');//definición de formato de header
        $pedido = Pedido::find()->where(['idPedido' => $idPedido])->one();
        $estado =  (int)$_POST['data']['payment']['status']['code'];//nuevo estado informado del pedido
        $pedido->idEstado = $this->estadoPedido($estado); 
        $pedido->save();    
        
        return true;        
    }


    /**
     * Retorna el estado que debe tener un pedido según estado retornado
     * @param integer $estado
     * @return integer
     */
    private function estadoPedido($estado){
        $nuevoEstado = 1;//estado default nuevo
        
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
        return $nuevoEstado;
    }
}


