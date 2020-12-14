<?php

namespace app\vendor\webservice;

use Yii;
use yii\base\Component;
use yii\httpclient\Client;
use yii\helpers\Json;


class Webservice extends Component
{
    
    public static function llamadaPago( $arrParams=array())
    {
        $urlapi = 'https://api.mobbex.com/p/';

        $client = new Client(['baseUrl' => $urlapi]);

        $response = $client->createRequest()
        ->setUrl('checkout')
        ->setMethod('POST')
        ->setData($arrParams)
        ->addHeaders(['content-type' => 'application/json',
                        'x-lang' => 'es',
                        'x-access-token' => 'd31f0721-2f85-44e7-bcc6-15e19d1a53cc',
                        'x-api-key' => 'zJ8LFTBX6Ba8D611e9io13fDZAwj0QmKO1Hn1yIj'])
        ->setOptions(['timeout'      => 20])//segundos
        ->send();
        $val = (array) json_decode($response->getContent(),true);
        $resultadoArray = array();
        $resultadoArray[0]= 0;
        if ($response->getContent() && $response->getIsOk())
        {
            $resultadoArray[0]= $val['result'];//exito de la comunicación
            $resultadoArray[1]=$val['data']['url'];// URL de checkout
        }   
        return $resultadoArray;
    }
}
