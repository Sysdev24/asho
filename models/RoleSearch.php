<?php

namespace app\models;

use yii\base\Model;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;


/**
 * PaymentSearch represents the model behind the search form of `app\models\Payment`.
 */
class RoleSearch extends Model
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

        $list = AuthRbac::searchInArrayData(AuthRbac::getRoles(), [
            'name'=>$this->name, 'description'=>$this->description
        ]);
        

        $dataProvider = new ArrayDataProvider([
            'allModels' => $list,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'attributes' => ['name','description'],
                'defaultOrder' => ['name' => SORT_ASC]
            ],
        ]);

        return $dataProvider;
    }



}

$auth = \Yii::$app->authManager;
// Busqueda dependiendo del usuario
$userId = \Yii::$app->user->identity->id;
$userRoles = $auth->getRolesByUser($userId);

// oculta estatus inactivo
if( !(ArrayHelper::keyExists('admin', $userRoles, false)) ) {
    $query->andFilterWhere(['id_estatus' => [1,4,5,6]]);
}