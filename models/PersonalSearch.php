<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Personal;

/**
 * PersonalSearch represents the model behind the search form of `app\models\Personal`.
 */
class PersonalSearch extends Personal
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ci', 'nro_empleado', 'id_gerencia', 'id_estado', 'id_estatus', 'id_cargo'], 'integer'],
            [['nombre', 'apellido', 'created_at', 'updated_at', 'telefono', 'fecha_nac'], 'safe'],
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
        $query = Personal::find();

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
            'ci' => $this->ci,
            'nro_empleado' => $this->nro_empleado,
            'id_gerencia' => $this->id_gerencia,
            'id_estado' => $this->id_estado,
            'id_estatus' => $this->id_estatus,
            'id_cargo' => $this->id_cargo,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'fecha_nac' => $this->fecha_nac,
        ]);

        $query->andFilterWhere(['ilike', 'nombre', $this->nombre])
            ->andFilterWhere(['ilike', 'apellido', $this->apellido])
            ->andFilterWhere(['ilike', 'telefono', $this->telefono]);

        return $dataProvider;
    }
}
