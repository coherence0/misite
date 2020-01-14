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
		$findDron->name_surname = $form->name_surname;
        $findDron->thirdname = $form->thirdname;
        $findDron->email = $form->email;
        $findDron->drone_id = $form->dron;
        $findDron->drone_reg_number = $form->drone_reg_number;
        $findDron->drone_serial_number = $form->drone_serial_number;
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
		$phone = mainPageFunc::getObjPhoneFromCode($form->verificationcode);
        $secondPhone = Phones::find()->where(['uid'=>$id, 'status'=>'1'])->one();
        if ($secondPhone != null){
            $secondPhone->status = 0;
            $secondPhone->save();
        }
        $findDron = FindDrons::findOne($id);
        $findDron->name_surname = $form->name_surname;
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
		$lostDron->name_surname = $form->name_surname;
        $lostDron->thirdname = $form->thirdname;
        $lostDron->email = $form->email;
        $lostDron->drone_id = $form->dron;
        $lostDron->drone_reg_number = $form->drone_reg_number;
        $lostDron->drone_serial_number = $form->drone_serial_number;
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
		Yii::$app->queue->push(new LostDronsJob($config));
     	Yii::$app->session->addFlash('success','Дрон добавлен');
	}

	public static function updateLostDron($form,$id){
		$phone = mainPageFunc::getObjPhoneFromCode($form->verificationcode);
        $secondPhone = Phones::find()->where(['uid'=>$id, 'status'=>'1'])->one();
        if ($secondPhone != null){
            $secondPhone->status = 0;
            $secondPhone->save();
        }
        $lostDron = LostDrons::findOne($id);
        $lostDron->name_surname = $form->name_surname;
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

    public static function getIdFromFindSerialNumber($serialNumber){
        return FindDrons::getIdFromDronSerialNumber($serialNumber);
    }

	public static function getIdFromLostRegNumber($regNumber){
		return LostDrons::getIdFromDronRegNumber($regNumber);
	}

    public static function getIdFromLostSerialNumber($serialNumber){
        return LostDrons::getIdFromDronSerialNumber($serialNumber);
    }

	public static function getObjPhoneFromCode($code){
		return Phones::findOne(Phones::getIdFromCode($code));
	}

	public static function getObjPhoneFromPhone($phone){
		return Phones::findOne(Phones::getIdFromPhone($phone));
	}

    public static function toLower(&$form){
        if (isset($form->drone_reg_number)){
            $form->drone_reg_number = strtolower($form->drone_reg_number);
        }
        if (isset($form->drone_serial_number)){
            $form->drone_serial_number = strtolower($form->drone_serial_number);
        }
    }

    public static function idIsFind($id){
        return $id ? false:true;
    }

    public static function getIdFromFindForm(&$form){
        $id = self::getIdFromFindRegNumber($form->drone_reg_number);
        if (self::idIsFind($id)) return $id;
        $id = self::getIdFromFindSerialNumber($form->drone_serial_number);
        return $id ? $id : null;
    }  

    public static function getIdFromLostForm(&$form){
        $id = getIdFromLostRegNumber($form->dron_reg_number);
        if (idIsFind($id)) return $id;
        $id = getIdFromLostSerialNumber($form->drond_serial_number);
        return $id ? $id : null;
    }
}