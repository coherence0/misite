<?php

namespace app\models;

use yii\base\Model;

class FindedDroneForm extends Model
{
    public $name;
    public $surname;
    public $thirdname;
    public $dron;
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
            [['id','name', 'email', 'surname','dron', 'idetificalNumber', 'phone'], 'required'],
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