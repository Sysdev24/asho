<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[PeliAgenCategoria]].
 *
 * @see PeliAgenCategoria
 */
class PeliagencategoriaQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return PeliAgenCategoria[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return PeliAgenCategoria|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
