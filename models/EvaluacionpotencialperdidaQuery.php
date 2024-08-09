<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[EvaluacionPotencialPerdida]].
 *
 * @see EvaluacionPotencialPerdida
 */
class EvaluacionpotencialperdidaQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return EvaluacionPotencialPerdida[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return EvaluacionPotencialPerdida|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
