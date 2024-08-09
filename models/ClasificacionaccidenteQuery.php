<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[ClasificacionAccidente]].
 *
 * @see ClasificacionAccidente
 */
class ClasificacionaccidenteQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ClasificacionAccidente[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ClasificacionAccidente|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
