<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[TipoTrabajo]].
 *
 * @see TipoTrabajo
 */
class TipotrabajoQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return TipoTrabajo[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return TipoTrabajo|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
