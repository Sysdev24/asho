<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[ExposicionContacCategoria]].
 *
 * @see ExposicionContacCategoria
 */
class ExposicioncontaccategoriaQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ExposicionContacCategoria[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ExposicionContacCategoria|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
