<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[SegundaPantalla]].
 *
 * @see SegundaPantalla
 */
class SegundapantallaQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return SegundaPantalla[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return SegundaPantalla|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
