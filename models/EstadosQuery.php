<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Estados]].
 *
 * @see Estados
 */
class EstadosQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Estados[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Estados|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
