<?php

namespace app\models;

use Yii;
use app\utiles\sensibleMayuscMinuscValidator;


class Bienes extends SujetoAfectacion
{

    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';

    public function rules()
    {
        return [
            [['id_con_afectacion'], 'default', 'value' => 2],

            [['id_clasif_con_afect', 'id_afectacion', 'id_estatus'], 'default', 'value' => null],
            [['id_clasif_con_afect', 'id_con_afectacion', 'id_afectacion', 'id_estatus'], 'integer'],
            [['descripcion', 'codigo'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['id_estatus'], 'exist', 'skipOnError' => true, 'targetClass' => Estatus::class, 'targetAttribute' => ['id_estatus' => 'id_estatus']],
            ['descripcion', 'match', 'pattern' => '/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]{2,255}$/', 'message' => 'Solo se admiten letras.'],
            [['descripcion'], sensibleMayuscMinuscValidator::class, 'on' => self::SCENARIO_CREATE],   
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_sujeto_afect' => 'Id Sujeto Afect',
            'id_clasif_con_afect' => 'Id Clasif Con Afect',
            'id_con_afectacion' => 'Id Con Afectacion',
            'id_afectacion' => 'Id Afectacion',
            'descripcion' => 'Descripcion',
            'codigo' => 'Codigo',
            'id_estatus' => 'Estatus',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    Public function guardar()
    {
        $model = self::findBySql('SELECT * FROM sujeto_afectacion_hijo(:suj_afec, :descripcion)', [':suj_afec' => 2, ':descripcion' => $this->descripcion])->one();

        if($model !== null) {
            return true;
        } 
        return false;
    }

    /**
     * Gets query for [[Estatus]].
     *
     * @return \yii\db\ActiveQuery|EstatusQuery
     */
    public function getEstatus()
    {
        return $this->hasOne(Estatus::class, ['id_estatus' => 'id_estatus'])->inverseOf('sujetoAfectacions');
    }

    /**
     * Gets query for [[Registros]].
     *
     * @return \yii\db\ActiveQuery|RegistroQuery
     */
    public function getRegistros()
    {
        return $this->hasMany(Registro::class, ['id_sujeto_afectacion' => 'id_sujeto_afect'])->inverseOf('sujetoAfectacion');
    }

    /**
     * {@inheritdoc}
     * @return SujetoafectacionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SujetoafectacionQuery(get_called_class());
    }
}
