<?php

namespace app\models;

use Yii;
use yii\base\BaseObject;
use app\models\LostDrons;
use app\models\FindDrons;
use app\models\funcForJobs;
define('FIND_RADIUS', 5000);

class FindDronsJob extends BaseObject implements \yii\queue\JobInterface
{
	
    public $fid;

    public function execute($queue)
    {
        $finded = FindDrons::findOne($this->fid);
        $title = 'Ваш дрон добавлен в базу';
        $body = 'Мы добавили ваш дрон в базу';
        funcForJobs::sendEmail($finded->email, $title, $body);
        $losted = LostDrons::find()->all();
        foreach ($losted as $key) {
            if ($key->status == 0 )
                continue;
            $result = funcForJobs::getСomparison($finded,$key);
            if ($result['status']){
                if ($result['differences'] == 0){
                    funcForJobs::sendEmail($key->email, 'Ваш дрон найден!', "Его нашел ".$finded->name_surname);
                    funcForJobs::setPair($key->id, $this->fid, 0, $result['distance']);
                    $key->status = 0;
                    $key->save();
                    $finded->status =0;
                    $finded->save();
                }elseif ($result['differences'] == 1 && $result['distance'] <= FIND_RADIUS) {
                    funcForJobs::sendEmail($key->email, 'Возможно ваш дрон найден!', "Его нашел ".$finded->name_surname);
                    funcForJobs::setPair($key->id, $this->fid, 1, $result['distance']);
                    $key->status = 0;
                    $key->save();
                    $finded->status = 0;
                    $finded->save();
                }
            }
        }
    }

}