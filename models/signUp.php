<?php

namespace app\models;

use yii\db\ActiveRecord;

class signUp extends ActiveRecord
{
	public static function tableName()
    {
        return 'user';
    }
	
}