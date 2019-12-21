<?php

namespace app\models;

use yii\base\Model;

class PhoneForm extends Model
{

    public $phone;


    public function rules()
    {
        return [
            ['phone', 'required','message'=>'Необходимо ввести номер телефона'],
            
        ];
    }
}