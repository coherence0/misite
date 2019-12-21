<?php

namespace app\models;

use yii\base\Model;

class LostedDroneForm extends Model
{
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
            //['phone', 'required', 'message'=>'Необходимо указать телефон'],
            ['email', 'required', 'message'=>'Введите пожалуйста ваш E-mail'],

            ['email', 'email'],
            ['number', 'number'],
            [
                'date',
                'date',
                'format'=>'php:d.m.Y',
                'timestampAttribute'=>'active_to',
            ],

        ];
    }
}