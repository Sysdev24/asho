<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Estados;
use app\models\Estatus;

use yii\db\Expression;

/**
 * EstadosSearch represents the model behind the search form of `app\models\Estados`.
 */
class EstadosSearch extends Estados
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_estado', /*'id_estatus',*/ 'id_regiones'], 'integer'],
            [['id_estatus'], 'safe'], //Se debe poner aqui para que pueda funcionar la busqueda
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
        $query = Estados::find();

        $query->joinWith('estatus'); // Unir la tabla "estatus" para que busque la descripcion y no el id

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
            'id_estado' => $this->id_estado,
            //'id_estatus' => $this->id_estatus,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'id_regiones' => $this->id_regiones,
        ]);

        $query->andFilterWhere(['ilike', 'descripcion', $this->descripcion]);

        //Filtro para que no busque por id sino por la descripcion o el campo requerido
        $query->andFilterWhere(['ilike', new Expression('estatus.descripcion::text'), $this->id_estatus]);

    
        return $dataProvider;
    }
}
