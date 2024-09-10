<?php

namespace app\models;

use yii\base\Model;
use yii\data\ArrayDataProvider;


/**
 * PaymentSearch represents the model behind the search form of `app\models\Payment`.
 */
class PermissionsSearch extends Model
{
    public $name;
    public $description;

    public function rules()
    {
        return [
            [['name', 'description'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => \Yii::t('app', 'Name'),
            'description' => \Yii::t('app', 'Description'),
        ];
    }

    /**
     * This method returns ArrayDataProvider.
     * Filtered and sorted if required.
     */
    public function search($params)
    {
        $this->load($params);

        $list = AuthRbac::searchInArrayData(AuthRbac::getPermissions(), [
            'name'=>$this->name, 'description'=>$this->description
        ]);

        $dataProvider = new ArrayDataProvider([
            'allModels' => $list,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'attributes' => ['name','description'],
                'defaultOrder' => ['name' => SORT_ASC, 'description' => SORT_ASC,]
            ],
        ]);

        return $dataProvider;
    }
}
