<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[TipoContacto]].
 *
 * @see TipoContacto
 */
class TipocontactoQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return TipoContacto[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return TipoContacto|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
