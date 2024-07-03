<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[NaturalezaAccidente]].
 *
 * @see NaturalezaAccidente
 */
class NaturalezaaccidenteQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return NaturalezaAccidente[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return NaturalezaAccidente|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
