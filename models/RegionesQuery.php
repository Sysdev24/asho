<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Regiones]].
 *
 * @see Regiones
 */
class RegionesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Regiones[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Regiones|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
