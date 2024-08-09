<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[SujetoAfectacion]].
 *
 * @see SujetoAfectacion
 */
class SujetoafectacionQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return SujetoAfectacion[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return SujetoAfectacion|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
