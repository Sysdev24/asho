<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Usuarios;
use yii\db\Expression;


/**
 * UsuariosSearch represents the model behind the search form of `app\models\Usuarios`.
 */
class UsuariosSearch extends Usuarios
{

    public $nombre;
    public $apellido;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_usuario', 'ci', 'id_estatus'], 'integer'],
            [['username', 'password', 'created_at', 'updated_at', 'authKey', 'accesstoken', 'name', 'nacionalidad', 'item_name', 'nombre', 'apellido', 'gerencia'], 'safe'],
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
        $query = Usuarios::find();

        $query->joinWith('personal');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([

            'attributes' => [
    
                'ci',
    
                'username',
                'id_estatus',
    
                'personal.nombre' => [
    
                    'asc' => ['personal.nombre' => SORT_ASC],
    
                    'desc' => ['personal.nombre' => SORT_DESC],
    
                ],
    
                'personal.apellido' => [
    
                    'asc' => ['personal.apellido' => SORT_ASC],
    
                    'desc' => ['personal.apellido' => SORT_DESC],
    
                ],

                'personal.nacionalidad' => [
    
                    'asc' => ['personal.nacionalidad' => SORT_ASC],
    
                    'desc' => ['personal.nacionalidad' => SORT_DESC],
    
                ],
            ],
    
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id_usuario' => $this->id_usuario,
            'id_estatus' => $this->id_estatus,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['ilike', 'username', $this->username])
        ->andFilterWhere(['ilike', 'password', $this->password])
        ->andFilterWhere(['ilike', 'authKey', $this->authKey])
        ->andFilterWhere(['ilike', 'accesstoken', $this->accesstoken])
        ->andFilterWhere(['ilike', 'name', $this->name])
        ->andFilterWhere(['ilike', 'item_name', $this->item_name]);

        // Filtrar por datos del personal asociado
        $query
        ->andFilterWhere(['ilike', 'personal.nombre', $this->nombre])
        ->andFilterWhere(['ilike', 'personal.apellido', $this->apellido])
        ->andFilterWhere(['ilike', 'personal.nacionalidad', $this->nacionalidad]);

        //$query->andFilterWhere(['ilike', new Expression('personal.nombre::text'), $this->ci]);



        return $dataProvider;
    }
}
