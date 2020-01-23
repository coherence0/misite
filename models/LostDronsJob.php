<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\base\BaseObject;
use app\models\LostDrons;
use app\models\FindDrons;
use app\models\funcForJobs;
define('FIND_RADIUS', 5000);

class LostDronsJob extends BaseObject implements \yii\queue\JobInterface
{
	
    public $lid;

    public function execute($queue)
    {
        $losted = LostDrons::findOne($this->lid);
        $finded = FindDrons::find()->all();
        $title = 'Ваш дрон добавлен в базу';
        $body = 'Мы добавили ваш дрон в базу';
        funcForJobs::sendEmail($finded->email, $title, $body);
        foreach ($finded as $key) {
            $result = funcForJobs::getСomparison($losted,$key);
            if ($result['status']){
                if ($result['differences'] == 0){
                    funcForJobs::sendEmail($losted->email, 'Ваш дрон найден!', "Его нашел ".$key->name_surname);
                    funcForJobs::setPair($this->lid, $key->id, 0, $result['distance']);
                    $losted->status = 0;
                    $losted->save();
                    $key->status = 0;
                    $key->save();
                }elseif ($result['differences'] == 1 && $result['distance'] <= FIND_RADIUS) {
                    funcForJobs::sendEmail($losted->email, 'Возможно ваш дрон найден!', "Его нашел ".$key->name_surname);
                    funcForJobs::setPair($this->lid, $key->id, 1, $result['distance']);
                    $losted->status = 0;
                    $losted->save();
                    $key->status = 0;
                    $key->save();
                }
            }
        }
    }
}