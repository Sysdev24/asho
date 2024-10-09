<?php
namespace app\models;


use Yii;
use app\utiles\sensibleMayuscMinuscValidator;



class Area extends AfectacionPersona
{
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';
    
    public function rules()
    {
        return [
            [['id_sub2_area_afect'], 'default', 'value' => 1],
            [['id_sub_area_afect'], 'default', 'value' => null], // Si quieres que se incremente automáticamente
            
            [['id_estatus'], 'default', 'value' => null],
            [['id_sub_area_afect', 'id_sub2_area_afect', 'id_estatus'], 'integer'],
            [['descripcion', 'codigo'], 'string'],
            [['descripcion'], 'required'],
            ['descripcion', 'match', 'pattern' => '/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]{2,255}$/', 'message' => 'Solo se admiten letras.'],
            [['created_at', 'updated_at'], 'safe'],
            [['id_estatus'], 'exist', 'skipOnError' => true, 'targetClass' => Estatus::class, 'targetAttribute' => ['id_estatus' => 'id_estatus']],
            [['descripcion'], sensibleMayuscMinuscValidator::className(), 'on' => self::SCENARIO_CREATE],   

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_area_afectada' => 'Id Area Afectada',
            'id_sub_area_afect' => 'Id Sub Area Afect',
            'id_sub2_area_afect' => 'Id Sub2 Area Afect',
            'descripcion' => 'Descripcion',
            'codigo' => 'Codigo',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'id_estatus' => 'Estatus',
        ];
    }

    Public function guardar()
    {
        $model = self::findBySql('SELECT * FROM insertar_afectacion_personas_hijo(:afec_per, :descripcion)', [':afec_per' => 1, ':descripcion' => $this->descripcion])->one();

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
        return $this->hasOne(Estatus::class, ['id_estatus' => 'id_estatus']);
    }

    /**
     * {@inheritdoc}
     * @return AfectacionpersonaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AfectacionpersonaQuery(get_called_class());
    }
    
    
    //Para que el id_sub_area_afect se incremente automáticamente
    public function beforeSave($insert)
    {
        if ($insert && $this->isNewRecord) {
            $this->id_sub_area_afect = self::find()
                ->where(['id_sub2_area_afect' => $this->id_sub2_area_afect])
                ->max('id_sub_area_afect') + 1;
        }

        return parent::beforeSave($insert);
    }

}