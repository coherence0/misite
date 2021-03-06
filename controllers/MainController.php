<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Url;
use app\models\forms\FindedDroneForm;
use app\models\forms\LostedDroneForm;
use app\models\forms\PhoneForm;
use app\models\Drons;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use yii\bootstrap4\ActiveForm;
use app\models\Pairs;
use app\models\PhonesHistory;
use app\models\helpModules\mainPageFunc;

class MainController extends Controller
{
    public function actionIndex(){                              
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


        if ($FindedDroneForm->load(Yii::$app->request->post()) && $FindedDroneForm->validate()){
            mainPageFunc::standardize($FindedDroneForm);
            $id = mainPageFunc::getIdFromFindForm($FindedDroneForm);
            //var_dump($id);die;
            if (!mainPageFunc::idIsFind($id)){
                $phone = mainPageFunc::getObjPhoneFromCode($FindedDroneForm->verificationcode);
                    if (mainPageFunc::phoneIsFind($phone)){
                        mainPageFunc::saveFindDron($FindedDroneForm,$phone);
                        return $this->goHome();
                    }    
            } else {
                    mainPageFunc::updateFindDron($FindedDroneForm,$id);
                    return $this->goHome();
            }
        } elseif ($LostedDroneForm->load(Yii::$app->request->post()) && $LostedDroneForm->validate()){
            mainPageFunc::standardize($LostedDroneForm);
            $id = mainPageFunc::getIdFromLostForm(strtolower($LostedDroneForm->drone_reg_number));
                if (!mainPageFunc::idIsFind($id)){
                $phone = mainPageFunc::getObjPhoneFromCode($LostedDroneForm->verificationcode);
                    if (mainPageFunc::phoneIsFind($phone)){
                        mainPageFunc::saveLostDron($LostedDroneForm,$phone);
                        return $this->goHome();
                    }    
                }else {
                        mainPageFunc::updateLostDron($LostedDroneForm,$id);
                        return $this->goHome();
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

    public function actionConfirm(){

        $PhoneForm = new PhoneForm();
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;



        // Если пришёл AJAX запрос
        if (Yii::$app->request->isAjax) { 
            $data = Yii::$app->request->post();
            //Yii::$app->response->format = Response::FORMAT_JSON;
            // Получаем данные модели из запроса
            if ($PhoneForm->load($data) && $PhoneForm->validate()) 
            {
                if (mainPageFunc::isSpam('89245004713')){
                    return [
                        "data"=>null,
                        "error"=>"Слишком много запросов на сегодня. (максимум 5)"
                    ];
                }
                //Если всё успешно, отправляем ответ с данными
                $phone = mainPageFunc::getObjPhoneFromPhone($PhoneForm->phone);
                if(!$phone){
                    mainPageFunc::sendSMS($PhoneForm->phone);
                    $status = 'Сообщение отправленно';  
                } else {
                    $time = time();
                    $phone->created_at += 60;
                    if ($time > $phone->created_at){
                        mainPageFunc::sendSMS($PhoneForm->phone);
                        $status = 'Сообщение отправленно';
                    }else {
                        $status = "Подождите " . ($phone->created_at - $time) . " секунд";
                    }
                }    
                return [
                    "data" => $PhoneForm->phone,
                    "error" => $status
                ];
            } else {
                // Если нет, отправляем ответ с сообщением об ошибке
                return [
                    "data" => null,
                    "error" => "Ошибка валидации"
                ];
            }
        } else {
            // Если это не AJAX запрос, отправляем ответ с сообщением об ошибке
            return [
                "data" => null,
                "error" => "Не AJAX запрос"
            ];
        }
    }


    // public function actionTest(){
    //     $phone = '+7(924)-500-47-13';
        
    //     var_dump($phoneClear);
    //     die;
    //     $pair = new Pairs();
    //     $finded = FindDrons::findOne(12);
    //     $losted = FindDrons::find()->all();
    //     foreach ($losted as $key) {
    //         $pair->setIsNewRecord(true);
    //         MainController::invarDistance($finded->drone_reg_number, $key->drone_reg_number, $out);
    //         $pair->id = null;
    //         $pair->fid = 12;
    //         $pair->lid = $key->id;
    //         $pair->match_rate = $out['Similarity'];
    //         $pair->save();
    //     }
    //     return $this->render('test',);
    // }

}