<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\RegistroReglaOro;

/**
 * RegistroreglaoroSearch represents the model behind the search form of `app\models\RegistroReglaOro`.
 */
class RegistroreglaoroSearch extends RegistroReglaOro
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_registro_regla_oro', 'id_estatus'], 'integer'],
            [['id_nro_accidente', 'id_opcion1', 'id_opcion2', 'id_opcion3', 'id_opcion4', 'id_opcion_5'], 'boolean'],
            [['created_at', 'updated_at'], 'safe'],
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
        $query = RegistroReglaOro::find();

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
            'id_registro_regla_oro' => $this->id_registro_regla_oro,
            'id_nro_accidente' => $this->id_nro_accidente,
            'id_opcion1' => $this->id_opcion1,
            'id_opcion2' => $this->id_opcion2,
            'id_opcion3' => $this->id_opcion3,
            'id_opcion4' => $this->id_opcion4,
            'id_opcion_5' => $this->id_opcion_5,
            'id_estatus' => $this->id_estatus,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        return $dataProvider;
    }
}
