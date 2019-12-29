<?php

namespace app\models;

use yii\base\Model;

class LostedDroneForm extends Model
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
            ['email', 'required', 'message'=>'Введите пожалуйста ваш E-mail'],
            ['date', 'required', 'message'=>'Укажите пожалуйста дату'],

            ['email', 'email'],
            [
                'date',
                'date',
                'format'=>'php:d.m.Y'
            ],


            //['name', 'string', 'length', 'max',=> 15,'message'=>'Имя должно быть не длинее 15 символов'],

            ['name','string','max'=>15,'tooLong'=>'Имя не может быть длинее 15 символов'],
            ['surname','string','max'=>15,'tooLong'=>'Фамилия не может быть длинее 15 символов'],
            ['thirdname','string','max'=>15,'tooLong'=>'Отчество не может быть длинее 15 символов'],

            ['thirdname', 'default', 'value'=>'нет'],

            ['verificationcode', 'validateVerificationCode'],

            ['idetificalNumber','match','pattern' => '/[a-z]{1}[0-9]{6}|[0-9]{1}[a-z]{1}[0-9]{5}|[0-9]{2}[a-z]{1}[0-9]{4}|[0-9]{3}[a-z]{1}[0-9]{3}|[0-9]{4}[a-z]{1}[0-9]{2}|[0-9]{5}[a-z]{1}[0-9]{1}|[0-9]{6}[a-z]{1}/i','message'=>'Неправильно введен номер дрона']

        ];
    }
    public function validateVerificationCode($attribute, $params){
        $id = Phones::getIdFromCode($this->$attribute);
        if ($id == NULL){
            $this->addError($attribute, 'Неверный код');
        }
    }
}