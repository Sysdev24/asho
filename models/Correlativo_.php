<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\db\StaleObjectException;

class Correlativo extends ActiveRecord
{
    public static function tableName()
    {
        return 'correlativos';
    }

    public static function generar($lateral)
    {
        $anio = date('y'); // Obtiene los dos últimos dígitos del año actual

        $transaction = \Yii::$app->db->beginTransaction(); // Inicia una transacción para asegurar la atomicidad

        try {
            // Busca un registro existente para el año y lateral dados
            $correlativo = self::find()->where(['anio' => $anio, 'lateral' => $lateral])->one();

            if (!$correlativo) { // Si no existe, crea uno nuevo
                $correlativo = new self();
                $correlativo->anio = $anio;
                $correlativo->lateral = $lateral;
                $correlativo->ultimo_numero = 0;
            }

            $correlativo->ultimo_numero++; // Incrementa el último número

            if (!$correlativo->save()) { // Guarda los cambios en la base de datos
                throw new \Exception("Error al guardar el correlativo: " . print_r($correlativo->errors, true));
            }

            $transaction->commit(); // Confirma la transacción

            // Formatea el número con ceros a la izquierda
            $aumento = str_pad($correlativo->ultimo_numero, 5, '0', STR_PAD_LEFT);

            return $anio . $aumento . $lateral; // Retorna el correlativo completo

        } catch (\Exception $e) {
            $transaction->rollBack(); // Revierte la transacción en caso de error
            \Yii::error($e); // Registra el error en los logs de Yii para depuración
            return null; // Retorna null en caso de error
        }
    }
}