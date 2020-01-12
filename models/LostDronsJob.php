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
        	LostDronsJob::invarDistance($losted->drone_reg_number, $key->drone_reg_number, $out);

        	if ($out['Similarity'] < 80)
        		continue; 

        	if ($out['Similarity'] == 100){
        		//отправляем письма

        		Yii::$app->mailer->compose()
                	    ->setTo($losted->email)
                    	->setFrom(["tdlyatesta@yandex.ru"=>'ya'])
                    	->setSubject('Ваш дрон найден!')
                    	->setTextBody("Его нашел ".$key->name)
                    	->send();

        	}elseif($out['Similarity'] > 80 && LostDronsJob::calculateTheDistance($lat1,$long1,$lat2,$long2) <= FIND_RADIUS) {
        		//отправляем письма
        		Yii::$app->mailer->compose()
                	    ->setTo($losted->email)
                    	->setFrom(["tdlyatesta@yandex.ru"=>'ya'])
                    	->setSubject('Возможно ваш дрон найден!')
                    	->setTextBody("Его нашел ".$key->name)
                    	->send();	
        	}

        	$pair->id = null;
        	$pair->lid = $this->fid;
        	$pair->fid = $key->id;
        	$pair->match_rate = $out['Similarity'];
        	$pair->distance = LostDronsJob::calculateTheDistance($lat1,$long1,$lat2,$long2);
        	$pair->save();
        }
    }

    private static function invarDistance($query,$rowV1,&$outpar){   
		$hs1 = array();
		$hs2 = array();
		$out = array();

		$query = LostDronsJob::translitIt($query);
		$query  = strtolower($query);
		$query = substr($query, 0, 255);
		$rowV1 = LostDronsJob::translitIt($rowV1);
		$rowV1  = strtolower($rowV1);
		$rowV1 = substr($rowV1, 0, 255);

		$query = preg_replace('/[^a-z0-9]/', '', $query);
		$rowV1 = preg_replace('/[^a-z0-9]/', '', $rowV1);

		$lengquery = strlen($query); 
		$lengrowV1 = strlen($rowV1); 

		$lengtotal = ($lengrowV1 + $lengquery); 
		$outpar{"lengtotal"}=$lengtotal;
//-------------------------count_chars()---------------------------------------------               
		foreach (count_chars($query, 1) as $i => $val) {
		      $ch = chr($i);
		      $q_hschar{$ch}=$val;
		}
		$mychar = count_chars($rowV1, 1);

		$hschar_copy;
		$hschar = array();
		foreach ($mychar as $key => $val) {
		   $ch = chr($key);
		   $hschar[$ch]=$val; 
		}

		$alfb = "abcdefghijklmnopqrstuvwxyz0123456789";   ## N-мерная метрика
		$alfbarr = preg_split("//",$alfb);

		$sum1 = 0;
		$sum2 = 0;
		$sumdel = 0;

		foreach($alfbarr as $aw){
		            if($aw!=""){
		                   $val="";
		                   if (!in_array($aw, $hschar))
		                   	continue;
		                   $val = $hschar[$aw];
		                   if($val){ 
		                            $vv=$val;   
		                             }else{ $vv=0; }
		                   $val2="";
		                   $val2 =  $q_hschar{$aw};
		                   if($val2){ 
		                             $vv2=$val2;   
		                             }else{ $vv2=0;}
 		                   $sumdel += abs($vv - $vv2);
		            }
		}       

		$per = 100*(1 - $sumdel/$lengtotal);
		$pern = sprintf("%5.2f", $per);
		$outpar{"Error.count"}=$sumdel;
		$outpar{"Similarity"}=$pern;
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
}