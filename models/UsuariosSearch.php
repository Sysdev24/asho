<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Usuarios;
use yii\db\Expression;
use yii\helpers\ArrayHelper;


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
            [['username', 'password', 'created_at', 'updated_at', 'authKey', 'accesstoken', 'name', 'nombre', 'apellido', 'gerencia'], 'safe'],
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
            ],
    
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
            $query->andFilterWhere(['usuarios.id_estatus' => [1,4,5,6]]);
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
        ->andFilterWhere(['ilike', 'name', $this->name]);

        // Filtrar por datos del personal asociado
        $query
        ->andFilterWhere(['ilike', 'personal.nombre', $this->nombre])
        ->andFilterWhere(['ilike', 'personal.apellido', $this->apellido]);

        //$query->andFilterWhere(['ilike', new Expression('personal.nombre::text'), $this->ci]);



        return $dataProvider;
    }
}
