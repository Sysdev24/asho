<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[ClasificacionIncidente]].
 *
 * @see ClasificacionIncidente
 */
class ClasificacionincidenteQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ClasificacionIncidente[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ClasificacionIncidente|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
