<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\AfectacionPersona;

/**
 * AfectacionpersonaSearch represents the model behind the search form of `app\models\AfectacionPersona`.
 */
class AfectacionpersonaSearch extends AfectacionPersona
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_area_afectada', 'id_sub_area_afect', 'id_sub2_area_afect', 'id_estatus'], 'integer'],
            [['descripcion', 'codigo', 'created_at', 'updated_at'], 'safe'],
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

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params, $searchType = 'area')
    {
        $query = AfectacionPersona::find();

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
            'id_area_afectada' => $this->id_area_afectada,
            'id_sub_area_afect' => $this->id_sub_area_afect,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'id_estatus' => $this->id_estatus,
        ]);

        $query->andFilterWhere(['ilike', 'descripcion', $this->descripcion])
            ->andFilterWhere(['ilike', 'codigo', $this->codigo]);

        // Condición adicional para excluir el ID 0 en id_sub2_area_afect
        $query->andWhere(['>', 'id_sub_area_afect', 0]);

        // Condición adicional según el tipo de búsqueda
        if ($searchType === 'area') {
            $query->andWhere(['id_sub2_area_afect' => 1]);
        } elseif ($searchType === 'naturaleza') {
            $query->andWhere(['id_sub2_area_afect' => 2]);
        }

        return $dataProvider;
    }
}
