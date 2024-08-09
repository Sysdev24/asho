<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "peligro_agente".
 *
 * @property int $id_pel_agen clave unica del peligro condicion o agente
 * @property int|null $id_sub2_clas_pel id de la 2era. clasificacion del peligro
 * @property int|null $id_sub_cla_pel id de la 1era. clasificacion del peligro
 * @property int|null $id_cla_pel id de la clasificacion del peligro
 * @property int|null $id_peligro id del peligro 
 * @property string|null $descripcion descripcion peligros, condiciones y agentes que estan en presente en un registro preliminar de accientes 
 * @property string|null $codigo codigo que representa los correlativos que componen la clasificacion de los accidente laborales operacionales y ambientales
 * @property string|null $created_at fecha y hora de creacion del registro
 * @property string|null $updated_at fecha y hora de la modificacion del registro
 * @property int|null $id_estatus estatus del registro Activo o Inactivo
 *
 * @property Estatus $estatus
 */
class PeligroAgente extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'peligro_agente';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_sub2_clas_pel', 'id_sub_cla_pel', 'id_cla_pel', 'id_peligro', 'id_estatus'], 'default', 'value' => null],
            [['id_sub2_clas_pel', 'id_sub_cla_pel', 'id_cla_pel', 'id_peligro', 'id_estatus'], 'integer'],
            [['descripcion', 'codigo'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['id_estatus'], 'exist', 'skipOnError' => true, 'targetClass' => Estatus::class, 'targetAttribute' => ['id_estatus' => 'id_estatus']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_pel_agen' => 'Id Pel Agen',
            'id_sub2_clas_pel' => 'Id Sub2 Clas Pel',
            'id_sub_cla_pel' => 'Id Sub Cla Pel',
            'id_cla_pel' => 'Id Cla Pel',
            'id_peligro' => 'Id Peligro',
            'descripcion' => 'Descripcion',
            'codigo' => 'Codigo',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'id_estatus' => 'Id Estatus',
        ];
    }

    /**
     * Gets query for [[Estatus]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEstatus()
    {
        return $this->hasOne(Estatus::class, ['id_estatus' => 'id_estatus']);
    }
}
