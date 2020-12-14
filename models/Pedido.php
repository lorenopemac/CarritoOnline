<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pedido".
 *
 * @property int $idPedido
 * @property int $numero
 * @property int $idEstado
 * @property int $idProducto
 * @property int $idUsuario
 */
class Pedido extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pedido';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [[ 'idEstado', 'idProducto'], 'required'],
            [['numero', 'idEstado', 'idProducto', 'idUsuario'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idPedido' => 'Id Pedido',
            'numero' => 'Numero',
            'idEstado' => 'Id Estado',
            'idProducto' => 'Id Producto',
            'idUsuario' => 'Id Usuario',
        ];
    }

    /**
     * {@inheritdoc}
     * @return PedidoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PedidoQuery(get_called_class());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstado()
    {
        return $this->hasOne(Estado::className(), ['idEstado' => 'idEstado']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducto()
    {
        return $this->hasOne(Producto::className(), ['idProducto' => 'idProducto']);
    }
}
