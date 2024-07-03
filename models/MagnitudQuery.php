<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Magnitud]].
 *
 * @see Magnitud
 */
class MagnitudQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Magnitud[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Magnitud|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
