<?php

namespace app\utiles;
//namespace app\components;

use yii\validators\Validator;

//use app\models\Unidad;
//use Yii;
//use yii\db\Query;

class sensibleMayuscMinuscValidator extends Validator
{

    public function eliminarEspacio($cadenat){
                
        // $cadenat = array(" ");
        // $nuevacadena = str_replace($cadenat, "", "vnombre");
        $cadenat = str_replace(
            array(' '),
            array(''),
            $cadenat
        );
        return $cadenat;
    }
    
    public function eliminartildes($cadena){

        //Codificamos la cadena en formato utf8 en caso de que nos de errores
        //$cadena = utf8_encode($cadena);
    
        //Ahora reemplazamos las letras
        $cadena = str_replace(
            array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
            array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
            $cadena
        );
    
        $cadena = str_replace(
            array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
            array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
            $cadena );
    
        $cadena = str_replace(
            array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
            array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
            $cadena );
    
        $cadena = str_replace(
            array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
            array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
            $cadena );
    
        $cadena = str_replace(
            array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
            array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
            $cadena );
    
        $cadena = str_replace(
            array('ñ', 'Ñ', 'ç', 'Ç'),
            array('n', 'N', 'c', 'C'),
            $cadena
        );
    
        return $cadena;
    }

    public function validateAttribute($model, $attribute)
    {

        $clase = get_class($model);
        $datosActuales = (new $clase())->find()->select($attribute)->asArray()->all();

        for ($i=0; $i < count($datosActuales); $i++) {

            $var1 = $model->$attribute;
            $var1sin = $this->eliminartildes($var1); //eliminando tildes de la informacion introducida por el usuario.
            $var1sin = $this->eliminarEspacio($var1sin); //eliminando espacios de la informacion introducida por el usuario.


            $var2 = $datosActuales[$i][$attribute];
            $var2sin = $this->eliminartildes($var2); //eliminando tildes de la informacion extraida de la base de datos para su posterior comparacion.
            $var2sin = $this->eliminarEspacio($var2sin); //eliminando espacios de la informacion extraida de la base de datos para su posterior comparacion.


            $nombrecampo = substr($attribute, 1);

            if (strcasecmp($var1sin, $var2sin) === 0){
                $this->addError($model, $attribute, "El ".$nombrecampo." '". $var1 . "' ya existe como '". $var2 ."'." );
            }
        }

    }



    

      
            

           

}