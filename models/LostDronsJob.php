<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\base\BaseObject;
use app\models\Pairs;
use app\models\LostDrons;
use app\models\FindDrons;
define('EARTH_RADIUS', 6372795);
define('FIND_RADIUS', 5000);

class LostDronsJob extends BaseObject implements \yii\queue\JobInterface
{
	
    public $fid;

    public function execute($queue)
    {
        $pair = new Pairs();
        $losted = LostDrons::findOne($this->fid);
        $finded = FindDrons::find()->all();

        foreach ($finded as $key) {
        	$pair->setIsNewRecord(true);
        	$lat1 = $losted->x_coords;
        	$long1 = $losted->y_coords;
        	$lat2 = $key->x_coords;
        	$long2 = $key->y_coords;

        	if ($losted->drone_reg_number == $key->drone_reg_number){
        		//отправляем письма
        		Yii::$app->mailer->compose()
                	    ->setTo($losted->email)
                    	->setFrom(["tdlyatesta@yandex.ru"=>'ya'])
                    	->setSubject('Ваш дрон найден!')
                    	->setTextBody("Его нашел ".$key->name)
                    	->send();
                $pair->id = null;
        		$pair->lid = $this->fid;
        		$pair->fid = $key->id;
        		$pair->match_rate = $out['Similarity'];
        		//$pair->distance = LostDronsJob::calculateTheDistance($lat1,$long1,$lat2,$long2);
        		$pair->save();
        	}elseif((LostDronsJob::calculateTheDistance($lat1,$long1,$lat2,$long2) <= FIND_RADIUS) && (LostDronsJob::countCoincidences($losted->drone_reg_number, $key->drone_reg_number)==1)) {
        		//отправляем письма
        		Yii::$app->mailer->compose()
                	    ->setTo($losted->email)
                    	->setFrom(["tdlyatesta@yandex.ru"=>'ya'])
                    	->setSubject('Возможно ваш дрон найден!')
                    	->setTextBody("Его нашел ".$key->name)
                    	->send();	

                $pair->id = null;
        		$pair->lid = $this->fid;
        		$pair->fid = $key->id;
        		$pair->match_rate = $out['Similarity'];
        		$pair->distance = LostDronsJob::calculateTheDistance($lat1,$long1,$lat2,$long2);
        		$pair->save();
        	}
        }
    }

	private static function translitIt($str){
    	$tr = array(
    	    "А"=>"A","Б"=>"B","В"=>"V","Г"=>"G",
    	    "Д"=>"D","Е"=>"E","Ж"=>"J","З"=>"Z","И"=>"I",
    	    "Й"=>"Y","К"=>"K","Л"=>"L","М"=>"M","Н"=>"N",
    	    "О"=>"O","П"=>"P","Р"=>"R","С"=>"S","Т"=>"T",
    	    "У"=>"U","Ф"=>"F","Х"=>"H","Ц"=>"TS","Ч"=>"CH",
    	    "Ш"=>"SH","Щ"=>"SCH","Ъ"=>"","Ы"=>"YI","Ь"=>"",
    	    "Э"=>"E","Ю"=>"YU","Я"=>"YA","а"=>"a","б"=>"b",
    	    "в"=>"v","г"=>"g","д"=>"d","е"=>"e","ж"=>"j",
    	    "з"=>"z","и"=>"i","й"=>"y","к"=>"k","л"=>"l",
    	    "м"=>"m","н"=>"n","о"=>"o","п"=>"p","р"=>"r",
    	    "с"=>"s","т"=>"t","у"=>"u","ф"=>"f","х"=>"h",
    	    "ц"=>"ts","ч"=>"ch","ш"=>"sh","щ"=>"sch","ъ"=>"y",
    	    "ы"=>"yi","ь"=>"","э"=>"e","ю"=>"yu","я"=>"ya"
    	);
    	return strtr($str,$tr);
	}

	private static function calculateTheDistance ($xA, $yA, $xB, $yB) {
 
	// перевести координаты в радианы
	$lat1 = $xA * M_PI / 180;
	$lat2 = $xB * M_PI / 180;
	$long1 = $yA * M_PI / 180;
	$long2 = $yB * M_PI / 180;
 
	// косинусы и синусы широт и разницы долгот
	$cl1 = cos($lat1);
	$cl2 = cos($lat2);
	$sl1 = sin($lat1);
	$sl2 = sin($lat2);
	$delta = $long2 - $long1;
	$cdelta = cos($delta);
	$sdelta = sin($delta);
 
	// вычисления длины большого круга
	$y = sqrt(pow($cl2 * $sdelta, 2) + pow($cl1 * $sl2 - $sl1 * $cl2 * $cdelta, 2));
	$x = $sl1 * $sl2 + $cl1 * $cl2 * $cdelta;
 
	//
	$ad = atan2($y, $x);
	$dist = $ad * EARTH_RADIUS;
 
	return $dist;
	}

	private static function countCoincidences($str1, $str2){
		if (strlen($str1)!= strlen($str2))
			return null;
		$difference = 0;
		$i = 0;
		for ($i; $i < strlen($str1); $i++){
			if ($str1[$i] != $str2[$i])
				$difference++;
		} 
		return $difference;
	}
}