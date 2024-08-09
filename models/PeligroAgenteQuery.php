<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[PeligroAgente]].
 *
 * @see PeligroAgente
 */
class PeligroAgenteQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return PeligroAgente[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return PeligroAgente|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
