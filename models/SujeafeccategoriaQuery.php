<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[SujeAfecCategoria]].
 *
 * @see SujeAfecCategoria
 */
class SujeafeccategoriaQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return SujeAfecCategoria[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return SujeAfecCategoria|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
