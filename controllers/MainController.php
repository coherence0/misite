<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\FindedDroneForm;
use app\models\LostedDroneForm;
use app\models\Drons;
use app\models\Phones;
use yii\helpers\ArrayHelper;
use app\models\PhoneForm;
use app\models\FindDrons;
use app\models\LostDrons;
use yii\web\Response;
use yii\bootstrap4\ActiveForm;
use app\models\FindeDronsJob;
use app\models\Pairs;

class MainController extends Controller
{
    public function actionIndex(){
     $config =[
        'fid' => '3'
        ];
        Yii::$app->queue->push(new FindeDronsJob($config));
        
    	$FindedDroneForm = new FindedDroneForm();
        $LostedDroneForm = new LostedDroneForm();
        $PhoneForm = new PhoneForm();

        $drons = Drons::find()->all();
        $items = ArrayHelper::map($drons, 'id', 'model');
        $params = [
            'prompt' => 'Укажите ваш дрон'
        ];

        
        if (Yii::$app->request->isAjax && $FindedDroneForm->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($FindedDroneForm);
        }

        if (Yii::$app->request->isAjax && $LostedDroneForm->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($LostedDroneForm);
        }

        if(Yii::$app->request->isPjax){
            if ($PhoneForm->load(Yii::$app->request->post()) && $PhoneForm->validate()){
                if(!Phones::findPhone($PhoneForm->phone)){
                    $phone = new Phones();

                    $phone->uid = 0;
                    $phone->phone = $PhoneForm->phone;
                    $phone->varification_code = mt_rand(1000,9999);
                    $phone->created_at = time();
                    $phone->status = 0;
                    $phone->save();
                    //delete($phone);
                    $status = 'Сообщение отправленно';  
                }else {
                    $time = time();
                    $phone = Phones::findOne(Phones::getIdFromPhone($PhoneForm->phone));
                    $phone->created_at += 60;
                    if ($time > $phone->created_at){
                        $phone->created_at = time();
                        $phone->save();
                        $status = 'Сообщение отправленно';
                    }else {
                        $status = "Подождите " . ($phone->created_at - $time) . " секунд";
                    }
                }
                
            } else {
                $status = 'Вы неверно ввели номер';
            }

            $values=[
            'FindedDroneForm' => $FindedDroneForm,
            'LostedDroneForm' => $LostedDroneForm,
            'PhoneForm' => $PhoneForm,
            'items' => $items,
            'params' => $params,
            'status' => $status,
            ];

            return $this->render('index', $values);
        }

        if ($FindedDroneForm->load(Yii::$app->request->post()) && $FindedDroneForm->validate()){
            $id = FindDrons::getIdFromDronRegNumber($FindedDroneForm->idetificalNumber);
            if ($id == NULL){
                $phone = Phones::findOne(Phones::getIdFromCode($FindedDroneForm->verificationcode));
                if ($phone != NULL){
                    $findDron = new FindDrons;
                    $findDron->name = $FindedDroneForm->name;
                    $findDron->surname = $FindedDroneForm->surname;
                    $findDron->thirdname = $FindedDroneForm->thirdname;
                    $findDron->drone_id = $FindedDroneForm->dron;
                    $findDron->drone_reg_number = $FindedDroneForm->idetificalNumber;
                    $findDron->date = $FindedDroneForm->date;
                    $findDron->x_coords = $FindedDroneForm->xCoords;
                    $findDron->y_coords = $FindedDroneForm->yCoords;
                    $findDron->created_at = time();
                    $findDron->save();
                    $phone->uid = $findDron->id;
                    $phone->varification_code = 0;
                    $phone->status = 1;
                    $phone->save();
                    $FindedDroneForm = new FindedDroneForm();
                    $LostedDroneForm = new LostedDroneForm();
                    $config =[
                        'fid' => $findDron->id
                    ];
                    Yii::$app->queue->delay(10)->push(new FindeDronsJob($config));
                    Yii::$app->session->addFlash('success','Дрон добавлен');
                }    
            }else {
                    $phone = Phones::findOne(Phones::getIdFromCode($FindedDroneForm->verificationcode));
                    $findDron = FindDrons::findOne($id);
                    $findDron->name = $FindedDroneForm->name;
                    $findDron->surname = $FindedDroneForm->surname;
                    $findDron->thirdname = $FindedDroneForm->thirdname;
                    $findDron->drone_id = $FindedDroneForm->dron;
                    $findDron->date = $FindedDroneForm->date;
                    $findDron->x_coords = $FindedDroneForm->xCoords;
                    $findDron->y_coords = $FindedDroneForm->yCoords;
                    $findDron->created_at = time();
                    $findDron->save();
                    $phone->uid = $findDron->id;
                    $phone->varification_code = 0;
                    $phone->status = 1;
                    $phone->save();
                    Yii::$app->session->addFlash('success','Данные о дроне обновлены');
                    $FindedDroneForm = new FindedDroneForm();
                    $LostedDroneForm = new LostedDroneForm();
            }
        } elseif ($LostedDroneForm->load(Yii::$app->request->post()) && $LostedDroneForm->validate()){
                    $id = LostDrons::getIdFromDronRegNumber($LostedDroneForm->idetificalNumber);
                    if ($id == NULL){
                
                    $phone = Phones::findOne(Phones::getIdFromCode($LostedDroneForm->verificationcode));
                    if ($phone != NULL){
                        $lostDron = new LostDrons;
                        $lostDron->name = $LostedDroneForm->name;
                        $lostDron->surname = $LostedDroneForm->surname;
                        $lostDron->thirdname = $LostedDroneForm->thirdname;
                        $lostDron->drone_id = $LostedDroneForm->dron;
                        $lostDron->drone_reg_number = $LostedDroneForm->idetificalNumber;
                        $lostDron->date = $LostedDroneForm->date;
                        $lostDron->x_coords = $LostedDroneForm->xCoords;
                        $lostDron->y_coords = $LostedDroneForm->yCoords;
                        $lostDron->created_at = time();
                        $lostDron->save();
                        $phone->uid = $lostDron->id;
                        $phone->varification_code = 0;
                        $phone->status = 1;
                        $phone->save();
                        Yii::$app->session->addFlash('success','Дрон добавлен');
                        $FindedDroneForm = new FindedDroneForm();
                        $LostedDroneForm = new LostedDroneForm();
                    }    
                }else {
                        $phone = Phones::findOne(Phones::getIdFromCode($LostedDroneForm->verificationcode));
                        $lostDron = LostDrons::findOne($id);
                        $lostDron->name = $LostedDroneForm->name;
                        $lostDron->surname = $LostedDroneForm->surname;
                        $lostDron->thirdname = $LostedDroneForm->thirdname;
                        $lostDron->drone_id = $LostedDroneForm->dron;
                        $lostDron->date = $LostedDroneForm->date;
                        $lostDron->x_coords = $LostedDroneForm->xCoords;
                        $lostDron->y_coords = $LostedDroneForm->yCoords;
                        $lostDron->created_at = time();
                        $lostDron->save();
                        $phone->uid = $lostDron->id;
                        $phone->varification_code = 0;
                        $phone->status = 1;
                        $phone->save();
                        Yii::$app->session->addFlash('success','Данные обновленны');
                        $FindedDroneForm = new FindedDroneForm();
                        $LostedDroneForm = new LostedDroneForm();
                    }
                }else {
                    $values=[
                    'FindedDroneForm' => $FindedDroneForm,
                    'LostedDroneForm' => $LostedDroneForm,
                    'PhoneForm' => $PhoneForm,
                    'items' => $items,
                    'params' => $params,
                ];
                return $this->render('index', $values);
            }
        
            $values=[
                'FindedDroneForm' => $FindedDroneForm,
                'LostedDroneForm' => $LostedDroneForm,
                'PhoneForm' => $PhoneForm,
                'items' => $items,
                'params' => $params,
            ];
        return $this->render('index', $values);
    }

    public function actionTest(){
        $pair = new Pairs();
        $finded = FindDrons::findOne(12);
        $losted = FindDrons::find()->all();
        foreach ($losted as $key) {
            $pair->setIsNewRecord(true);
            MainController::invarDistance($finded->drone_reg_number, $key->drone_reg_number, $out);
            $pair->id = null;
            $pair->fid = 12;
            $pair->lid = $key->id;
            $pair->match_rate = $out['Similarity'];
            $pair->save();
        }
        return $this->render('test',);
    }

}