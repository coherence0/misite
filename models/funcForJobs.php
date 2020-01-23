<?php 

namespace app\models;

use Yii;

define('EARTH_RADIUS', 6372795);

class funcForJobs
{

	public static function calculateTheDistance ($xA, $yA, $xB, $yB) {
 
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

	public static function getCountOfDifferences($str1, $str2){
		$reply = array();

		if (strlen($str1) == 0 || strlen($str2) == 0){
			$reply['status'] = false;
			return $reply;
		}

		if (strlen($str1)!= strlen($str2)){
			$reply['status'] = false;
			return $reply;
		}
		$difference = 0;
		for ($i = 0; $i < strlen($str1); $i++){
			if ($str1[$i] != $str2[$i])
				$difference++;
		} 
		$reply['status'] = true;
		$reply['differences'] = $difference;
		return $reply;
	}

	public static function getСomparison($obj1, $obj2){

		$reg = self::getCountOfDifferences($obj1->drone_reg_number, $obj2->drone_reg_number);
		$serial = self::getCountOfDifferences($obj1->drone_serial_number, $obj2->drone_serial_number);

		$reply['status'] = false;
		$reply['differences'] = 0;

		$lat1 = $obj1->x_coords;
        $long1 = $obj1->y_coords;
        $lat2 = $obj2->x_coords;
        $long2 = $obj2->y_coords;

		$reply['distance'] = self::calculateTheDistance($lat1,$long1,$lat2,$long2);

		if ($reg['status']){
			$reply['status'] = true;
			$reply['differences'] = $reg['differences'];
			if ($serial['status']){
				$reply['differences'] = (($reply > $serial['differences']) ? $serial['differences'] : $reply);
			}
		} else {
			if ($serial['status']){
				$reply['status'] = true;
				$reply['differences'] = $serial['differences'];
			}
		}
		return $reply;
	}

	public static function sendEmail($to, $title, $body){
		Yii::$app->mailer->compose()
                	    ->setTo($to)
                    	->setFrom(["tdlyatesta@yandex.ru"=>'ya'])
                    	->setSubject($title)
                    	->setTextBody($body)
                    	->send();
	}

	public static function setPair($lid, $fid, $differences, $distance){
		$pair = new Pairs();
		$pair->setIsNewRecord(true);
		$pair->id = null;
        $pair->lid = $lid;
        $pair->fid = $fid;
        $pair->match_rate = $differences;
        $pair->distance = $distance;
        $pair->save();
	}

}