<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[AfectacionBienesProcesos]].
 *
 * @see AfectacionBienesProcesos
 */
class AfectacionbienesprocesosQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return AfectacionBienesProcesos[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return AfectacionBienesProcesos|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
