<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SujetoAfectacion;

/**
 * SujetoAfectacionSearch represents the model behind the search form of `app\models\SujetoAfectacion`.
 */
class SujetoAfectacionSearch extends SujetoAfectacion
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_sujeto_afect', 'id_clasif_con_afect', 'id_con_afectacion', 'id_afectacion', 'id_estatus'], 'integer'],
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
    //Query para buscar el estatus (activo, inactivo, etc).
            //Parametros: $data:$searchModel /  $id: id_estatus
            public function buscarEstatus($data, $id){
                $modelbuscar = Estatus::findOne($data->id_estatus);
                $content = $modelbuscar->descripcion;
                return $content;
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
        $query = SujetoAfectacion::find();

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
            'id_sujeto_afect' => $this->id_sujeto_afect,
            'id_clasif_con_afect' => $this->id_clasif_con_afect,
            'id_con_afectacion' => $this->id_con_afectacion,
            'id_afectacion' => $this->id_afectacion,
            'id_estatus' => $this->id_estatus,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['ilike', 'descripcion', $this->descripcion])
            ->andFilterWhere(['ilike', 'codigo', $this->codigo]);

        return $dataProvider;
    }
}
