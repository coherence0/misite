<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lost_drons".
 *
 * @property int $id
 * @property string $name
 * @property string $surname
 * @property string $thirdname
 * @property string $email
 * @property int $drone_id
 * @property string $drone_reg_number
 * @property string $date
 * @property string $x_coords
 * @property string $y_coords
 * @property string $created_at
 */
class LostDrons extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lost_drons';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id','name_surname','thirdname','drone_id','drone_reg_number','drone_reg_number','email','date','x_coords','y_coords'],'trim'],

            ['name_surname','required','message'=>'Пожалуйста введите Имя и Фамилию'],
            ['thirdname', 'default'],
            ['drone_id','required','message'=>'Необходимо указать марку и модель дрона'],
            ['drone_reg_number', 'default','value'=>''],
            ['drone_serial_number', 'default','value'=>''],
            ['email', 'required', 'message'=>'Введите пожалуйста ваш E-mail'],
            ['date', 'required', 'message'=>'Укажите пожалуйста дату'],

            ['email', 'email','message'=>'Введите корректный E-mail'],
            [
                'date',
                'date',
                'format'=>'php:Y-m-d',
            ],


            //['name', 'string', 'length', 'max',=> 15,'message'=>'Имя должно быть не длинее 15 символов'],

            ['name_surname','string','max'=>35,'tooLong'=>'Имя и Фамилия не может быть длинее 35 символов'],
            ['thirdname','string','max'=>15,'tooLong'=>'Отчество не может быть длинее 15 символов'],

            ['thirdname', 'default', 'value'=>'нет'],

            //['verificationcode','match','pattern'=>'/[0-9]{5}/','message'=>'Неверный код'],

            ['drone_reg_number','validateRegNumber','message'=>'Неправильно введен номер дрона'],
            ['x_coords', 'double'],
            ['y_coords', 'double']

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name_surname' => 'Name',
            'thirdname' => 'Thirdname',
            'email' => 'Email',
            'drone_id' => 'Drone ID',
            'drone_reg_number' => 'Drone Reg Number',
            'drone_serial_number' => 'Drone serial Number',
            'date' => 'Date',
            'x_coords' => 'X Coords',
            'y_coords' => 'Y Coords',
            'created_at' => 'Created At',
        ];
    }

    public function validateRegNumber($attribute, $param){
        if ($this->$attribute != ''){
            $regexp = '/[a-z]{1}[0-9]{6}|[0-9]{1}[a-z]{1}[0-9]{5}|[0-9]{2}[a-z]{1}[0-9]{4}|[0-9]{3}[a-z]{1}[0-9]{3}|[0-9]{4}[a-z]{1}[0-9]{2}|[0-9]{5}[a-z]{1}[0-9]{1}|[0-9]{6}[a-z]{1}/i';
            if (!preg_match($regexp, $this->$attribute))
                $this->addError($attribute, 'Неправильно введен номер дрона');
        }
    }

    public static function getIdFromDronRegNumber($DronRegNumber){
        return LostDrons::find()->where(['drone_reg_number'=>$DronRegNumber])->one()['id'];
    }
}
