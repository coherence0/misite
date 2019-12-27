<?php

namespace app\models;

use yii\base\BaseObject;
use app\models\Pairs;
use app\models\LostDrons;
use app\models\FindDrons;

class FindeDronsJob extends BaseObject implements \yii\queue\JobInterface
{
    public $fid;

    public function execute($queue)
    {
        $pair = new Pairs();
        $finded = FindDrons::findOne($this->fid);
        $losted = FindDrons::find()->all();
        foreach ($losted as $key) {
        	$pair->setIsNewRecord(true);
        	FindeDronsJob::invarDistance($finded->drone_reg_number, $key->drone_reg_number, $out);
        	$pair->id = null;
        	$pair->fid = $this->fid;
        	$pair->lid = $key->id;
        	$pair->match_rate = $out['Similarity'];
        	$pair->save();
        }
    }

    private static function invarDistance($query,$rowV1,&$outpar){   
		$hs1 = array();
		$hs2 = array();
		$out = array();

		$query = FindeDronsJob::translitIt($query);
		$query  = strtolower($query);
		$query = substr($query, 0, 255);
		$rowV1 = FindeDronsJob::translitIt($rowV1);
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
		foreach ($mychar as $key => $val) {
		   $ch = chr($key);
		   $hschar{$ch}=$val; 
		}

		$alfb = "abcdefghijklmnopqrstuvwxyz0123456789";   ## N-мерная метрика
		$alfbarr = preg_split("//",$alfb);

		$sum1 = 0;
		$sum2 = 0;
		$sumdel = 0;

		foreach($alfbarr as $aw){
		            if($aw!=""){
		                   $val="";
		                   $val =  $hschar{$aw};
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
}