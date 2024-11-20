<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[TipAccCategoria]].
 *
 * @see TipAccCategoria
 */
class TipacccategoriaQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return TipAccCategoria[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return TipAccCategoria|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
