<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Estatus;

/**
 * EstatusSearch represents the model behind the search form of `app\models\Estatus`.
 */
class EstatusSearch extends Estatus
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_estatus'], 'integer'],
            [['siglas', 'descripcion', 'created_at', 'updated_at'], 'safe'],
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

// //Query para buscar el estatus (activo, inactivo, etc).
//     //Parametros: $data:$searchModel /  $id: id_estatus
//     public function buscarEstatus($data, $id) {
//         if ($data->estatus && $data->estatus->descripcion) {
//             return $data->estatus->descripcion;
//         } else {
//             return 'N/A'; // O el valor que desees mostrar cuando no hay estatus
//         }
//     }


    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Estatus::find();

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

        // grid filtering conditions
        $query->andFilterWhere([
            'id_estatus' => $this->id_estatus,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['ilike', 'siglas', $this->siglas])
            //->andFilterWhere(['ilike', 'descripcion', $this->descripcion])
            ->andFilterWhere(['not in', 'descripcion', ['ACTIVO', 'INACTIVO']]);

        return $dataProvider;
    }
}
