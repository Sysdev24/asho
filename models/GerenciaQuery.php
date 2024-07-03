<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Gerencia]].
 *
 * @see Gerencia
 */
class GerenciaQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Gerencia[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Gerencia|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
