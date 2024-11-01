<?php

namespace app\models;

use Yii;
use app\utiles\sensibleMayuscMinuscValidator;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "gerencia".
 *
 * @property int $id_gerencia Se registra el consecutivo de las gerencias de corpoelec
 * @property string|null $descripcion Se registra el nombre de la gerencia
 * @property int|null $id_estatus estatus del registro Activo o Inactivo
 * @property string|null $created_at Se archiva cuando fue creado 
 * @property string|null $updated_at fecha y hora de la modificacion del registro
 *
 * @property Estatus $estatus
 * @property Personal[] $personals
 * @property Registro[] $registros
 * @property Usuarios[] $usuarios
 */
class Gerencia extends \yii\db\ActiveRecord
{
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gerencia';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descripcion'], 'string'],
            [['descripcion'], 'required'],
            [['id_estatus'], 'default', 'value' => null],
            [['id_estatus'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['id_estatus'], 'exist', 'skipOnError' => true, 'targetClass' => Estatus::class, 'targetAttribute' => ['id_estatus' => 'id_estatus']],
            ['descripcion', 'match', 'pattern' => '/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]{2,255}$/', 'message' => 'Solo se admiten letras.'],
            [['descripcion'], sensibleMayuscMinuscValidator::class, 'on' => self::SCENARIO_CREATE],
         ];
    }

    //Para utilizar los campos created_at y updated_at
    public function behaviors() 
    {
         return [ TimestampBehavior::class => [
             'class' => TimestampBehavior::class, 
             'attributes' => [ 
                ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'], 
                ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'], 
            ], 
            'value' => function() { return date('Y-m-d H:i:s'); }, // Formato para datetime 
            ], 
        ]; 
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_gerencia' => 'Gerencia',
            'descripcion' => 'Descripcion',
            'id_estatus' => 'Estatus',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Estatus]].
     *
     * @return \yii\db\ActiveQuery|EstatusQuery
     */
    public function getEstatus()
    {
        return $this->hasOne(Estatus::class, ['id_estatus' => 'id_estatus'])->inverseOf('gerencias');
    }

    /**
     * Gets query for [[Personals]].
     *
     * @return \yii\db\ActiveQuery|PersonalQuery
     */
    public function getPersonals()
    {
        return $this->hasMany(Personal::class, ['id_gerencia' => 'id_gerencia'])->inverseOf('gerencia');
    }

    /**
     * Gets query for [[Registros]].
     *
     * @return \yii\db\ActiveQuery|RegistroQuery
     */
    public function getRegistros()
    {
        return $this->hasMany(Registro::class, ['id_gerencia' => 'id_gerencia'])->inverseOf('gerencia');
    }

    /**
     * Gets query for [[Usuarios]].
     *
     * @return \yii\db\ActiveQuery|UsuariosQuery
     */
    public function getUsuarios()
    {
        return $this->hasMany(Usuarios::class, ['id_gerencia' => 'id_gerencia'])->inverseOf('gerencia');
    }

    /**
     * {@inheritdoc}
     * @return GerenciaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new GerenciaQuery(get_called_class());
    }
}
