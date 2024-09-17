<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[AfectacionPersona1]].
 *
 * @see AfectacionPersona1
 */
class AfectacionPersona1Query extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return AfectacionPersona1[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return AfectacionPersona1|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
