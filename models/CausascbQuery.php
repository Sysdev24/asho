<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[CausasCb]].
 *
 * @see CausasCb
 */
class CausascbQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return CausasCb[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return CausasCb|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
