<?php

//use Yii;
use app\models\FindDrons;
use app\models\LostDrons;
use app\models\Phones;
use app\models\SendSmsJob;

namespace app\models;
use Yii;
class mainPageFunc 
{

	public static function saveFindDron ($form, $phone){
		$findDron = new FindDrons;
		$findDron->name = $form->name;
        $findDron->surname = $form->surname;
        $findDron->thirdname = $form->thirdname;
        $findDron->email = $form->email;
        $findDron->drone_id = $form->dron;
        $findDron->drone_reg_number = $form->idetificalNumber;
        $findDron->date = $form->date;
        $findDron->x_coords = $form->xCoords;
        $findDron->y_coords = $form->yCoords;
        $findDron->created_at = time();
        $findDron->save();
        $phone->uid = $findDron->id;
        $phone->varification_code = 0;
        $phone->status = 1;
        $phone->save();
        $config =[
                   'fid' => $findDron->id
                ];
		Yii::$app->queue->push(new FindDronsJob($config));
     	Yii::$app->session->addFlash('success','Дрон добавлен');
	}

	public static function updateFindDron($form,$id){
		$phone = mainPageFunc::getPhoneFromCode($form->verificationcode);;
        $findDron = FindDrons::findOne($id);
        $findDron->name = $form->name;
        $findDron->surname = $form->surname;
        $findDron->thirdname = $form->thirdname;
        $findDron->email = $form->email;
        $findDron->drone_id = $form->dron;
        $findDron->date = $form->date;
        $findDron->x_coords = $form->xCoords;
        $findDron->y_coords = $form->yCoords;
        $findDron->created_at = time();
        $findDron->save();
        $phone->uid = $findDron->id;
        $phone->varification_code = 0;
        $phone->status = 1;
        $phone->save();
        Yii::$app->session->addFlash('success','Данные о дроне обновлены');
	}

	public static function saveLostDron ($form, $phone){
		$lostDron = new LostDrons;
		$lostDron->name = $form->name;
        $lostDron->surname = $form->surname;
        $lostDron->thirdname = $form->thirdname;
        $lostDron->email = $form->email;
        $lostDron->drone_id = $form->dron;
        $lostDron->drone_reg_number = $form->idetificalNumber;
        $lostDron->date = $form->date;
        $lostDron->x_coords = $form->xCoords;
        $lostDron->y_coords = $form->yCoords;
        $lostDron->created_at = time();
        $lostDron->save();
        $phone->uid = $lostDron->id;
        $phone->varification_code = 0;
        $phone->status = 1;
        $phone->save();
        $config =[
                   'fid' => $lostDron->id
                ];
		Yii::$app->queue->push(new FindDronsJob($config));
     	Yii::$app->session->addFlash('success','Дрон добавлен');
	}

	public static function updateLostDron($form,$id){
		$phone = mainPageFunc::getPhoneFromCode($form->verificationcode);;
        $lostDron = LostDrons::findOne($id);
        $lostDron->name = $form->name;
        $lostDron->surname = $form->surname;
        $lostDron->thirdname = $form->thirdname;
        $lostDron->email = $form->email;
        $lostDron->drone_id = $form->dron;
        $lostDron->date = $form->date;
        $lostDron->x_coords = $form->xCoords;
        $lostDron->y_coords = $form->yCoords;
        $lostDron->created_at = time();
        $lostDron->save();
        $phone->uid = $lostDron->id;
        $phone->varification_code = 0;
        $phone->status = 1;
        $phone->save();
        Yii::$app->session->addFlash('success','Данные о дроне обновлены');
	}

	public static function sendSMS($phone){
		$config =[
            'phone' => $phone,
		];
        Yii::$app->queue->push(new SendSmsJob($config));
	}

	public static function getIdFromFindRegNumber($regNumber){
		return FindDrons::getIdFromDronRegNumber($regNumber);
	}

	public static function getIdFromLostRegNumber($regNumber){
		return LostDrons::getIdFromDronRegNumber($regNumber);
	}

	public static function getObjPhoneFromCode($code){
		return Phones::findOne(Phones::getIdFromCode($code));
	}

	public static function getObjPhoneFromPhone($phone){
		return Phones::findOne(Phones::getIdFromPhone($phone));
	}
}