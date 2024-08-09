<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[AfectacionPersona]].
 *
 * @see AfectacionPersona
 */
class AfectacionpersonaQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return AfectacionPersona[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return AfectacionPersona|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
