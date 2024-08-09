<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[SeveridadPotencialPerdida]].
 *
 * @see SeveridadPotencialPerdida
 */
class SeveridadpotencialperdidaQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return SeveridadPotencialPerdida[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return SeveridadPotencialPerdida|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
