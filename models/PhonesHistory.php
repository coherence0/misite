<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "phones_history".
 *
 * @property int $id
 * @property string $phone
 * @property string $used_time
 */
class PhonesHistory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'phones_history';
    }

    public static function getCountRecentRequests($phone){
        return self::find()->where(['between', 'time', time()-86400, time()])->andWhere(['phone'=>$phone])->count();
    }
}
