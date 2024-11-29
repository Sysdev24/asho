<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[PersonaNatural]].
 *
 * @see PersonaNatural
 */
class PersonanaturalQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return PersonaNatural[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return PersonaNatural|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
