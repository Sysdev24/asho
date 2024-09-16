<?
namespace app\widgets;

use yii\base\Widget;
use app\models\AfectacionPersona;

class CreateForm extends Widget
{
    public $type;

    public function run()
    {
        $model = new AfectacionPersona();

        if ($this->type === 'area') {
            return $this->render('//afectacionpersona/_form-area', [
                'model' => $model,
            ]);
        } elseif ($this->type === 'naturaleza') {
            return $this->render('//afectacionpersona/_form-naturaleza', [
                'model' => $model,
            ]);
        }
    }
}