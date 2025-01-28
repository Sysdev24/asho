<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Personal;
use yii\helpers\ArrayHelper;

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
            [['nombre', 'apellido', 'created_at', 'updated_at', 'telefono', 'fecha_nac', 'nacionalidad', 'correo'], 'safe'],
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
            ->andFilterWhere(['ilike', 'telefono', $this->telefono])
            ->andFilterWhere(['ilike', 'nacionalidad', $this->nacionalidad])
            ->andFilterWhere(['ilike', 'correo', $this->correo]);

        return $dataProvider;
    }
}