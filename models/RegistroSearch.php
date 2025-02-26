<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Registro;

/**
 * RegistroSearch represents the model behind the search form of `app\models\Registro`.
 */
class RegistroSearch extends Registro
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_registro', 'id_estado', 'cedula_supervisor_60min', 'id_estatus_proceso', 'id_region', 'cedula_reporta', 'cedula_pers_accide', 'cedula_validad_60min', 'id_magnitud', 'id_tipo_accidente', 'id_tipo_trabajo', 'id_peligro_agente', 'id_sujeto_afectacion', 'cedula_24horas', 'cedula_valid_24horas', 'id_gerencia', 'correlativo', 'id_naturaleza_accidente', 'id_requerimiento_trabajo_24h', 'id_afec_per_categoria'], 'integer'],
            [['fecha_hora', 'lugar', 'nro_accidente', 'observaciones_60min', 'created_at', 'updated_at', 'acciones_tomadas_60min', 'acciones_tomadas_24horas', 'observaciones_24horas', 'recomendaciones_24horas', 'descripcion_accidente_60min', 'ocurrencia_hecho_60m', 'acciones_tomadas_24h', 'observaciones_24h', 'validado_por_24h'], 'safe'],
            [['autorizado_60m', 'autorizado_24horas'], 'boolean'],
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

    //Query para buscar el estado.
    //Parametros: $data:$searchModel /  $id: id_estado
    public function buscarEstados($data, $id){
        $modelbuscar = Estados::findOne($data->id_estado);
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
        $query = Registro::find();

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
            'id_registro' => $this->id_registro,
            'id_estado' => $this->id_estado,
            'fecha_hora' => $this->fecha_hora,
            'cedula_supervisor_60min' => $this->cedula_supervisor_60min,
            'autorizado_60m' => $this->autorizado_60m,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'id_estatus_proceso' => $this->id_estatus_proceso,
            'id_region' => $this->id_region,
            'cedula_reporta' => $this->cedula_reporta,
            'cedula_pers_accide' => $this->cedula_pers_accide,
            'cedula_validad_60min' => $this->cedula_validad_60min,
            'id_magnitud' => $this->id_magnitud,
            'id_tipo_accidente' => $this->id_tipo_accidente,
            'id_tipo_trabajo' => $this->id_tipo_trabajo,
            'id_peligro_agente' => $this->id_peligro_agente,
            'id_sujeto_afectacion' => $this->id_sujeto_afectacion,
            'cedula_24horas' => $this->cedula_24horas,
            'autorizado_24horas' => $this->autorizado_24horas,
            'cedula_valid_24horas' => $this->cedula_valid_24horas,
            'id_gerencia' => $this->id_gerencia,
            'correlativo' => $this->correlativo,
            'id_naturaleza_accidente' => $this->id_naturaleza_accidente,
            'id_requerimiento_trabajo_24h' => $this->id_requerimiento_trabajo_24h,
            'id_afec_per_categoria' => $this->id_afec_per_categoria,
        ]);

        $query->andFilterWhere(['ilike', 'lugar', $this->lugar])
            ->andFilterWhere(['ilike', 'nro_accidente', $this->nro_accidente])
            ->andFilterWhere(['ilike', 'observaciones_60min', $this->observaciones_60min])
            ->andFilterWhere(['ilike', 'acciones_tomadas_60min', $this->acciones_tomadas_60min])
            ->andFilterWhere(['ilike', 'acciones_tomadas_24horas', $this->acciones_tomadas_24horas])
            ->andFilterWhere(['ilike', 'observaciones_24horas', $this->observaciones_24horas])
            ->andFilterWhere(['ilike', 'recomendaciones_24horas', $this->recomendaciones_24horas])
            ->andFilterWhere(['ilike', 'descripcion_accidente_60min', $this->descripcion_accidente_60min])
            ->andFilterWhere(['ilike', 'ocurrencia_hecho_60m', $this->ocurrencia_hecho_60m])
            ->andFilterWhere(['ilike', 'acciones_tomadas_24h', $this->acciones_tomadas_24h])
            ->andFilterWhere(['ilike', 'observaciones_24h', $this->observaciones_24h])
            ->andFilterWhere(['ilike', 'validado_por_24h', $this->validado_por_24h]);

        return $dataProvider;
    }
}
