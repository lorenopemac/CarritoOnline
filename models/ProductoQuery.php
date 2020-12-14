<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Producto]].
 *
 * @see Producto
 */
class ProductoQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Producto[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Producto|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
