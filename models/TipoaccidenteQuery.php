<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[TipoAccidente]].
 *
 * @see TipoAccidente
 */
class TipoaccidenteQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return TipoAccidente[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return TipoAccidente|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
