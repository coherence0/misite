<?php

namespace app\models;

use yii\base\Model;

class LostedDroneForm extends Model
{
    public $name;
    public $surname;
    public $thirdname;
    public $idetificalNumber;
    public $email;
    public $phone;
    public $verificationcode;
    public $date;
    public $xCoords;
    public $yCoords;

    public function rules()
    {
        return [
            [['id','name', 'email', 'surname', 'idetificalNumber', 'phone'], 'required'],
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