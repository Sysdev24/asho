<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "registro_adicional".
 *
 * @property int $id_registro_adicional
 * @property int|null $id_registro
 * @property string|null $nro_accidente
 * @property int|null $id_estatus_proceso
 * @property string|null $acciones_tomadas_60min
 * @property int|null $id_magnitud
 * @property int|null $id_tipo_accidente
 * @property int|null $id_tipo_trabajo
 * @property int|null $id_peligro_agente
 * @property int|null $id_sujeto_afectacion
 * @property int|null $id_naturaleza_accidente
 * @property int|null $id_afec_per_categoria
 * @property int|null $id_exposicion_con_cat
 *
 * @property AfecPerCategoria $afecPerCategoria
 * @property Estatus $estatusProceso
 * @property ExposicionContacCategoria $exposicionConCat
 * @property Magnitud $magnitud
 * @property NaturalezaAccidente $naturalezaAccidente
 * @property PeliAgenCategoria $peligroAgente
 * @property Registro $registro
 * @property SujeAfecCategoria $sujetoAfectacion
 * @property TipAccCategoria $tipoAccidente
 * @property TipoTrabajo $tipoTrabajo
 */
class RegistroAdicional extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'registro_adicional';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_registro', 'nro_accidente', 'acciones_tomadas_60min', 'id_magnitud', 'id_tipo_accidente', 'id_tipo_trabajo', 'id_peligro_agente', 'id_sujeto_afectacion', 'id_naturaleza_accidente', 'id_afec_per_categoria', 'id_exposicion_con_cat'], 'default', 'value' => null],
            [['id_estatus_proceso'], 'default', 'value' => 1],
            [['id_registro', 'id_estatus_proceso', 'id_magnitud', 'id_tipo_accidente', 'id_tipo_trabajo', 'id_peligro_agente', 'id_sujeto_afectacion', 'id_naturaleza_accidente', 'id_afec_per_categoria', 'id_exposicion_con_cat'], 'default', 'value' => null],
            [['id_registro', 'id_estatus_proceso', 'id_magnitud', 'id_tipo_accidente', 'id_tipo_trabajo', 'id_peligro_agente', 'id_sujeto_afectacion', 'id_naturaleza_accidente', 'id_afec_per_categoria', 'id_exposicion_con_cat'], 'integer'],
            [['nro_accidente', 'acciones_tomadas_60min'], 'string'],
            [['id_afec_per_categoria'], 'exist', 'skipOnError' => true, 'targetClass' => AfecPerCategoria::class, 'targetAttribute' => ['id_afec_per_categoria' => 'id']],
            [['id_estatus_proceso'], 'exist', 'skipOnError' => true, 'targetClass' => Estatus::class, 'targetAttribute' => ['id_estatus_proceso' => 'id_estatus']],
            [['id_exposicion_con_cat'], 'exist', 'skipOnError' => true, 'targetClass' => ExposicionContacCategoria::class, 'targetAttribute' => ['id_exposicion_con_cat' => 'id']],
            [['id_magnitud'], 'exist', 'skipOnError' => true, 'targetClass' => Magnitud::class, 'targetAttribute' => ['id_magnitud' => 'id_magnitud']],
            [['id_naturaleza_accidente'], 'exist', 'skipOnError' => true, 'targetClass' => NaturalezaAccidente::class, 'targetAttribute' => ['id_naturaleza_accidente' => 'id_naturaleza_accidente']],
            [['id_peligro_agente'], 'exist', 'skipOnError' => true, 'targetClass' => PeliAgenCategoria::class, 'targetAttribute' => ['id_peligro_agente' => 'id']],
            [['id_registro'], 'exist', 'skipOnError' => true, 'targetClass' => Registro::class, 'targetAttribute' => ['id_registro' => 'id_registro']],
            [['id_sujeto_afectacion'], 'exist', 'skipOnError' => true, 'targetClass' => SujeAfecCategoria::class, 'targetAttribute' => ['id_sujeto_afectacion' => 'id']],
            [['id_tipo_accidente'], 'exist', 'skipOnError' => true, 'targetClass' => TipAccCategoria::class, 'targetAttribute' => ['id_tipo_accidente' => 'id']],
            [['id_tipo_trabajo'], 'exist', 'skipOnError' => true, 'targetClass' => TipoTrabajo::class, 'targetAttribute' => ['id_tipo_trabajo' => 'id_tipo_trabajo']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_registro_adicional' => 'Id Registro Adicional',
            'id_registro' => 'Id Registro',
            'nro_accidente' => 'Nro Accidente',
            'id_estatus_proceso' => 'Id Estatus Proceso',
            'acciones_tomadas_60min' => 'Acciones Tomadas 60min',
            'id_magnitud' => 'Id Magnitud',
            'id_tipo_accidente' => 'Id Tipo Accidente',
            'id_tipo_trabajo' => 'Id Tipo Trabajo',
            'id_peligro_agente' => 'Id Peligro Agente',
            'id_sujeto_afectacion' => 'Id Sujeto Afectacion',
            'id_naturaleza_accidente' => 'Id Naturaleza Accidente',
            'id_afec_per_categoria' => 'Id Afec Per Categoria',
            'id_exposicion_con_cat' => 'Id Exposicion Con Cat',
        ];
    }

    /**
     * Gets query for [[AfecPerCategoria]].
     *
     * @return \yii\db\ActiveQuery|AfecpercategoriaQuery
     */
    public function getAfecPerCategoria()
    {
        return $this->hasOne(AfecPerCategoria::class, ['id' => 'id_afec_per_categoria']);
    }

    /**
     * Gets query for [[EstatusProceso]].
     *
     * @return \yii\db\ActiveQuery|EstatusQuery
     */
    public function getEstatusProceso()
    {
        return $this->hasOne(Estatus::class, ['id_estatus' => 'id_estatus_proceso']);
    }

    /**
     * Gets query for [[ExposicionConCat]].
     *
     * @return \yii\db\ActiveQuery|ExposicioncontaccategoriaQuery
     */
    public function getExposicionConCat()
    {
        return $this->hasOne(ExposicionContacCategoria::class, ['id' => 'id_exposicion_con_cat']);
    }

    /**
     * Gets query for [[Magnitud]].
     *
     * @return \yii\db\ActiveQuery|MagnitudQuery
     */
    public function getMagnitud()
    {
        return $this->hasOne(Magnitud::class, ['id_magnitud' => 'id_magnitud']);
    }

    /**
     * Gets query for [[NaturalezaAccidente]].
     *
     * @return \yii\db\ActiveQuery|NaturalezaaccidenteQuery
     */
    public function getNaturalezaAccidente()
    {
        return $this->hasOne(NaturalezaAccidente::class, ['id_naturaleza_accidente' => 'id_naturaleza_accidente']);
    }

    /**
     * Gets query for [[PeligroAgente]].
     *
     * @return \yii\db\ActiveQuery|PeliagencategoriaQuery
     */
    public function getPeligroAgente()
    {
        return $this->hasOne(PeliAgenCategoria::class, ['id' => 'id_peligro_agente']);
    }

    /**
     * Gets query for [[Registro]].
     *
     * @return \yii\db\ActiveQuery|RegistroQuery
     */
    public function getRegistro()
    {
        return $this->hasOne(Registro::class, ['id_registro' => 'id_registro']);
    }

    /**
     * Gets query for [[SujetoAfectacion]].
     *
     * @return \yii\db\ActiveQuery|SujeafeccategoriaQuery
     */
    public function getSujetoAfectacion()
    {
        return $this->hasOne(SujeAfecCategoria::class, ['id' => 'id_sujeto_afectacion']);
    }

    /**
     * Gets query for [[TipoAccidente]].
     *
     * @return \yii\db\ActiveQuery|TipacccategoriaQuery
     */
    public function getTipoAccidente()
    {
        return $this->hasOne(TipAccCategoria::class, ['id' => 'id_tipo_accidente']);
    }

    /**
     * Gets query for [[TipoTrabajo]].
     *
     * @return \yii\db\ActiveQuery|TipotrabajoQuery
     */
    public function getTipoTrabajo()
    {
        return $this->hasOne(TipoTrabajo::class, ['id_tipo_trabajo' => 'id_tipo_trabajo']);
    }

    /**
     * {@inheritdoc}
     * @return RegistroAdicionalQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RegistroAdicionalQuery(get_called_class());
    }

}
