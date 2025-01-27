<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SujetoAfectacion;
use yii\helpers\ArrayHelper;

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
    public function search($params, $searchType = 'persona')
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

            // Condición adicional para excluir el ID 0 en id_sub2_area_afect
        $query->andWhere(['>', 'id_clasif_con_afect', 0]);

        // Condición adicional según el tipo de búsqueda
        if ($searchType === 'personas') {
            $query->andWhere(['id_con_afectacion' => 1]);
        } elseif ($searchType === 'bienes') {
            $query->andWhere(['id_con_afectacion' => 2]);
        }elseif ($searchType === 'procesos') {
            $query->andWhere(['id_con_afectacion' => 3]);
        }elseif ($searchType === 'ambiente') {
            $query->andWhere(['id_con_afectacion' => 4]);
        }

        return $dataProvider;
    }
}
