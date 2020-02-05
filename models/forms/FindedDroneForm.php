<?php

namespace app\models\forms;

use yii\base\Model;
use app\models\Phones;

class FindedDroneForm extends Model
{
    public $id;
    public $name_surname;
    public $thirdname;
    public $dron;
    public $drone_reg_number;
    public $drone_serial_number;
    public $email;
    //public $phone;
    public $verificationcode;
    public $date;
    public $xCoords;
    public $yCoords;
    public $iAgree = false;

    public function rules()
    {//Sdelat' trim
        return [
            //[['id', 'email'], 'required'],
            [['id','name_surname','thirdname','dron','drone_reg_number','email','verificationcode','date','xCoords','yCoords', 'iAgree'],'trim'],

            ['name_surname','required','message'=>'Пожалуйста введите Имя'],
            ['thirdname', 'default'],
            ['dron','required','message'=>'Необходимо указать марку и модель дрона'],
            ['drone_reg_number', 'default','value'=>''],
            ['drone_reg_number', 'string', 'length' => 7,'notEqual'=>'Неправильно введен номер дрона'],
            ['drone_reg_number', 'validateRegNumber','skipOnEmpty' => false],
            ['drone_serial_number', 'default','value'=>''],
            ['drone_serial_number', 'validateSerialNumber','skipOnEmpty' => false],
            ['verificationcode', 'required', 'message'=>'Необходимо ввести код из СМС'],
            ['date', 'required', 'message'=>'Укажите пожалуйста дату'],
            ['email', 'required', 'message'=>'Введите пожалуйста ваш E-mail'],

            ['email', 'email','message'=>'Введите корректный E-mail'],
            [
                'date',
                'date',
                'format'=>'php:Y-m-d',
            ],
            ['iAgree', 'required'],
            ['iAgree', 'boolean'],

            ['iAgree', 'compare', 'compareValue' => 1, 'message'=>'Необходимо ваше подтверждение'],


            //['name', 'string', 'length', 'max',=> 15,'message'=>'Имя должно быть не длинее 15 символов'],

            ['name_surname','string','max'=>35,'tooLong'=>'Имя и Фамилия не может быть длинее 35 символов'],
            ['thirdname','string','max'=>15,'tooLong'=>'Отчество не может быть длинее 15 символов'],

            
            ['thirdname', 'default', 'value'=>'нет'],

            ['verificationcode', 'validateVerificationCode'],

            //['verificationcode','match','pattern'=>'/[0-9]{5}/','message'=>'Неверный код'],

            // ['drone_reg_number','match','pattern' => '','message'=>'Неправильно введен номер дрона'],
            ['xCoords', 'double'],
            ['yCoords', 'double']

        ];
    }

    public function validateVerificationCode($attribute, $params){
        $id = Phones::getIdFromCode($this->$attribute);
        if ($id == NULL){
            $this->addError($attribute, 'Неверный код');
        }
    }

    public function validateRegNumber($attribute, $param){
        if ($this->$attribute == '' && $this->drone_serial_number == '')
            $this->addError($attribute, 'Необходимо внести либо учетный номер дрона либо серийный номер');
        if ($this->$attribute != ''){
            $regexp = '/[a-z]{1}[0-9]{6}|[0-9]{1}[a-z]{1}[0-9]{5}|[0-9]{2}[a-z]{1}[0-9]{4}|[0-9]{3}[a-z]{1}[0-9]{3}|[0-9]{4}[a-z]{1}[0-9]{2}|[0-9]{5}[a-z]{1}[0-9]{1}|[0-9]{6}[a-z]{1}/i';
            if (!preg_match($regexp, $this->$attribute))
                $this->addError($attribute, 'Неправильно введен номер дрона');
        }
    }

    public function validateSerialNumber($attribute, $param){
        if ($this->$attribute == '' && $this->drone_reg_number == '')
            $this->addError($attribute, 'Необходимо внести либо учетный номер дрона либо серийный номер');
    }
}