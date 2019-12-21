<?php

namespace app\models;

use yii\db\ActiveRecord;

class FindDrons extends ActiveRecord
{

	public static function getIdFromDronRegNumber($DronRegNumber){
		return FindDrons::find()->where(['drone_reg_number'=>$DronRegNumber])->one()['id'];
	}
	
}