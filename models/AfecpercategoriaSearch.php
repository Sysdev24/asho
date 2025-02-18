<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\AfecPerCategoria;
use yii\helpers\ArrayHelper;


/**
 * AfecpercategoriaSearch represents the model behind the search form of `app\models\AfecPerCategoria`.
 */
class AfecpercategoriaSearch extends AfecPerCategoria
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'parent_id', 'id_estatus'], 'integer'],
            [['name', 'complete_name', 'parent_path', 'codigo', 'created_at', 'updated_at'], 'safe'],
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
        $query = AfecPerCategoria::find();

        // add conditions that should always apply here

        // Ordenar por id (ascendente)
        $query->orderBy(['id' => SORT_ASC]); // Ordena los resultados por 'id'
        
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
            'id' => $this->id,
            //'parent_id' => $this->parent_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'id_estatus' => $this->id_estatus,
        ]);

        $query->andFilterWhere(['ilike', 'name', $this->name])
            ->andFilterWhere(['ilike', 'complete_name', $this->complete_name])
            ->andFilterWhere(['ilike', 'parent_path', $this->parent_path])
            ->andFilterWhere(['ilike', 'codigo', $this->codigo])
            ->andWhere(['parent_id' => null]);

        return $dataProvider;
    }
}
