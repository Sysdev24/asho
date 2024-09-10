<?php
namespace app\widgets;

use Yii;
use yii\helpers\Html;

use app\models\Notification;

/**
 *
 */
class Notify
{
    const TYPE_IMAGE = Notification::TYPE_IMAGE;
    const TYPE_ICON = Notification::TYPE_ICON;

    /**
     * [create description]
     *
     * @param  array $options ['title'=>'Title', 'message'=> 'Message', 'target'=>user_id]
     * @return [type]          [description]
     *
     * EXAMPLE:
     * 
     * Notify::create(['title'=>'The Title', 'message'=> 'Quisque pulvinar tellus sit amet sem scelerisque tincidunt.', 'image'=>'<i class="fa fa-bug media-object bg-primary"></i>']);
     * Notify::create([
     *     'title'=>'New Email From John', 
     *      'message'=> 'Quisque pulvinar tellus sit amet sem scelerisque tincidunt.',
     *     'image'=>'<i class="fa fa-envelope media-object bg-secondary"></i><i class="fab fa-google text-warning media-object-icon fs-14px"></i>'
     * ]);
     *
     */
    public static function create($options)
    {
        $notification = new Notification();
        try {
            $notification->target = isset($options['target']) ? $options['target'] : Yii::$app->user->identity->id;
            $notification->title = $options['title'];
            $notification->message = $options['message'];
            $notification->image = $options['image'];
            $notification->image_type = $options['image_type'];
            if (!$notification->save()) {
                Yii::$app->getSession()->setFlash('error', [
                    [
                        'type' => 'toast',
                        'title' => Yii::t('app', 'Create {modelClass}', ['modelClass'=>Yii::t('app', 'Notification')]) . ':',
                        'message' => Yii::t('app', 'The record has not been saved successfully.') . 
                        '</br>' . (YII_ENV_DEV ? self::listErrors($notification->getErrors()) : ''),
                    ]
                ]);
            }
        } catch (\Exception $e) {
            if (YII_ENV_DEV) {
                var_dump($e);
                echo self::listErrors($notification->getErrors());
            }
        }

    }

    public static function getTotal()
    {
        $notification = Notification::find()->where(['target'=>Yii::$app->user->identity->id, 'status'=>Notification::STATUS_ACTIVE])->all();
        return count($notification);
    }

    public static function notifications()
    {
        $notification = Notification::find()->where(['target'=>Yii::$app->user->identity->id, 'status'=>Notification::STATUS_ACTIVE])->orderBy(['id' => SORT_DESC])->all();
        return $notification;
    }

    /**
     * Undocumented function
     *
     * @param [type] $id
     * @return void
     */
    public static function viewed($id)
    {
        $notification = Notification::findOne($id);
        $notification->status = Notification::STATUS_VIEWED;
        return $notification->save();
    }

    public static function viewAllByUser()
    {
        $notifications = Notification::find()->where(['target'=>Yii::$app->user->identity->id, 'status'=>Notification::STATUS_ACTIVE])->all();
        foreach ($notifications as $notification) {
            $notification->status = Notification::STATUS_VIEWED;
            $notification->save();
        }
    }

    public static function viewAllByList($list)
    {
        foreach ($list as $id) {
            $notification = Notification::findOne($id);
            $notification->status = Notification::STATUS_VIEWED;
            $notification->save();
        }
        return true; 
        // TODO: Validations
    }

    /**
     * Errors list from $model
     */
    public static function listErrors($errors) 
    {
        $html = '';
        foreach ($errors as $field => $value) {
            $html .= Html::beginTag('ul', ['class'=>""]);
            $html .=    Html::beginTag('li', ['class'=>""]);
            $html .=        Html::tag('strong', $field, ['class' => 'me-2']);
            foreach ($value as $val) {
                $html .= "$val</br>";
            }
            $html .=    Html::endTag('li');
            $html .= Html::endTag('ul');
        }
        return $html;
    }
}
