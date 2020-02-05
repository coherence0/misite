<?php

namespace app\models;

use Yii;
use yii\base\BaseObject;
use app\models\Phones;
use app\models\Smsru;

class SendSmsJob extends BaseObject implements \yii\queue\JobInterface
{
	
    public $phone;

    public function execute($queue)
    {
    	//$phoneObj=null;
    	$smsru = new SMSRU('563B9ED3-D999-2B35-EFD5-12D357F0B989'); // Ваш уникальный программный ключ, который можно получить на главной странице
    	$phoneInfo = Phones::findOne(Phones::getIdFromPhone($this->phone));
    	if (!$phoneInfo){
    		$phone = new Phones();
            $phone->uid = 0;
            $phone->phone = $this->phone;
            $phone->varification_code = mt_rand(10000,99999);
            $phone->created_at = time();
            $phone->status = 0;

            $data = new \stdClass();
			$data->to = $this->phone;
			$data->text = $phone->varification_code;
			$sms = $smsru->send_one($data);
            $phone->save();
            mainPageFunc::addPhoneToHistory($PhoneForm->phone);
    	}else {
            $phoneInfo->varification_code = mt_rand(10000,99999);
    		$phoneInfo->created_at = time();
            
            $data = new \stdClass();
            $data->to = $this->phone;
            $data->text = $phoneInfo->varification_code;
            $sms = $smsru->send_one($data);
            $phoneInfo->save();
            mainPageFunc::addPhoneToHistory($PhoneForm->phone);
    	}
    }
}