<?php

namespace app\models;

use yii\db\ActiveRecord;

class LostDrons extends ActiveRecord
{

	public static function getIdFromDronRegNumber($DronRegNumber){
		return LostDrons::find()->where(['drone_reg_number'=>$DronRegNumber])->one()['id'];
	}
	
}