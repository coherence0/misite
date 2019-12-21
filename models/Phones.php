<?php

namespace app\models;

use yii\db\ActiveRecord;

class Phones extends ActiveRecord
{

	public static function findPhone($phone){
		$val = Phones::find()->where(['phone'=> $phone])->one();
		if ($val != NULL){
			return (true);
		}else {
			return (false);
		}
	}

	public static function getIdFromPhone($phone){
		return Phones::find()->where(['phone'=>$phone])->one()['id'];
	}

	public static function getIdFromCode($code){
		return Phones::find()->where(['varification_code'=>$code])->one()['id'];
	}
	
}