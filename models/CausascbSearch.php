<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\CausasCb;
use yii\helpers\ArrayHelper;

/**
 * CausascbSearch represents the model behind the search form of `app\models\CausasCb`.
 */
class CausascbSearch extends CausasCb
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_causas_cb', 'id_sub2_fac', 'id_sub_fac', 'id_cau_fac_bas_raiz', 'id_cau_bas_raiz', 'id_estatus'], 'integer'],
            [['descripcion', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    //Query para buscar el estatus (activo, inactivo, etc).
    //Parametros: $data:$searchModel /  $id: id_estatus
    public function buscarEstatus($data, $id) {
        if ($data->estatus && $data->estatus->descripcion) {
            return $data->estatus->descripcion;
        } else {
            return 'N/A'; // O el valor que desees mostrar cuando no hay estatus
        }
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = CausasCb::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $auth = \Yii::$app->authManager;
        // Busqueda dependiendo del usuario
        $userId = \Yii::$app->user->identity->id;
    	$userRoles = $auth->getRolesByUser($userId);

        // oculta estatus inactivo
        if( !(ArrayHelper::keyExists('admin', $userRoles, false)) ) {
            $query->andFilterWhere(['id_estatus' => [1,4,5,6]]);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id_causas_cb' => $this->id_causas_cb,
            'id_sub2_fac' => $this->id_sub2_fac,
            'id_sub_fac' => $this->id_sub_fac,
            'id_cau_fac_bas_raiz' => $this->id_cau_fac_bas_raiz,
            'id_cau_bas_raiz' => $this->id_cau_bas_raiz,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'id_estatus' => $this->id_estatus,
        ]);

        $query->andFilterWhere(['ilike', 'descripcion', $this->descripcion]);

        return $dataProvider;
    }
}
