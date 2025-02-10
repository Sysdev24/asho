<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PersonaNatural;

/**
 * PersonanaturalSearch represents the model behind the search form of `app\models\PersonaNatural`.
 */
class PersonanaturalSearch extends PersonaNatural
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_registro', 'id_estatus', 'cedula'], 'integer'],
            [['nombre', 'apellido', 'created_at', 'updated_at', 'telefono', 'fecha_nac', 'empresa'], 'safe'],
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
    public function search($params)
    {
        $query = PersonaNatural::find();

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
            'id' => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'fecha_nac' => $this->fecha_nac,
            'id_registro' => $this->id_registro,
            'id_estatus' => $this->id_estatus,
            'cedula' => $this->cedula,
        ]);

        $query->andFilterWhere(['ilike', 'nombre', $this->nombre])
            ->andFilterWhere(['ilike', 'apellido', $this->apellido])
            ->andFilterWhere(['ilike', 'telefono', $this->telefono])
            ->andFilterWhere(['ilike', 'empresa', $this->empresa]);

        return $dataProvider;
    }
}
