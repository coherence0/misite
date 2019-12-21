<?php

namespace app\models;

use yii\base\Model;
use app\models\Phones;

class FindedDroneForm extends Model
{
    public $id;
    public $name;
    public $surname;
    public $thirdname;
    public $dron;
    public $idetificalNumber;
    public $email;
    //public $phone;
    public $verificationcode;
    public $date;
    public $xCoords;
    public $yCoords;

    public function rules()
    {//Sdelat' trim
        return [
            //[['id', 'email'], 'required'],
            [['id','name','surname','thirdname','dron','idetificalNumber','email','verificationcode','date','xCoords','yCoords'],'trim'],

            ['name','required','message'=>'Пожалуйста введите Имя'],
            ['surname','required', 'message'=>'Пожалуйста введите Фамилию'],
            ['thirdname', 'default'],
            ['dron','required','message'=>'Необходимо указать марку и модель дрона'],
            ['idetificalNumber', 'required', 'message'=>'Необходимо указать идентификационный номер дрона'],
            ['verificationcode', 'required', 'message'=>'Необходимо ввести код из СМС'],
            ['date', 'required', 'message'=>'Укажите пожалуйста дату'],
            ['email', 'required', 'message'=>'Введите пожалуйста ваш E-mail'],

            ['email', 'email'],
            [
                'date',
                'date',
                'format'=>'php:d.m.Y',
            ],


            //['name', 'string', 'length', 'max',=> 15,'message'=>'Имя должно быть не длинее 15 символов'],

            ['name','string','max'=>15,'tooLong'=>'Имя не может быть длинее 15 символов'],
            ['surname','string','max'=>15,'tooLong'=>'Фамилия не может быть длинее 15 символов'],
            ['thirdname','string','max'=>15,'tooLong'=>'Отчество не может быть длинее 15 символов'],

            
            ['thirdname', 'default', 'value'=>'нет'],

            ['verificationcode', 'validateVerificationCode'],

        ];
    }

    public function validateVerificationCode($attribute, $params){
        $id = Phones::getIdFromCode($this->$attribute);
        if ($id == NULL){
            $this->addError($attribute, 'Неверный код');
        }
    }
}