<?php

namespace app\models;
use app\models\Drons;
use Yii;

/**
 * This is the model class for table "find_drons".
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
class FindDrons extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'find_drons';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id','name','surname','thirdname','drone_id','drone_reg_number','email','date','x_coords','y_coords'],'trim'],

            ['name','required','message'=>'Пожалуйста введите Имя'],
            ['surname','required', 'message'=>'Пожалуйста введите Фамилию'],
            ['thirdname', 'default'],
            ['drone_id','required','message'=>'Необходимо указать марку и модель дрона'],
            ['drone_reg_number', 'required', 'message'=>'Необходимо указать идентификационный номер дрона'],
            ['email', 'required', 'message'=>'Введите пожалуйста ваш E-mail'],
            ['date', 'required', 'message'=>'Укажите пожалуйста дату'],

            ['email', 'email','message'=>'Введите корректный E-mail'],
            [
                'date',
                'date',
                'format'=>'php:Y-m-d',
            ],


            //['name', 'string', 'length', 'max',=> 15,'message'=>'Имя должно быть не длинее 15 символов'],

            ['name','string','max'=>15,'tooLong'=>'Имя не может быть длинее 15 символов'],
            ['surname','string','max'=>15,'tooLong'=>'Фамилия не может быть длинее 15 символов'],
            ['thirdname','string','max'=>15,'tooLong'=>'Отчество не может быть длинее 15 символов'],

            ['thirdname', 'default', 'value'=>'нет'],

            //['verificationcode','match','pattern'=>'/[0-9]{5}/','message'=>'Неверный код'],

            ['drone_reg_number','match','pattern' => '/[a-z]{1}[0-9]{6}|[0-9]{1}[a-z]{1}[0-9]{5}|[0-9]{2}[a-z]{1}[0-9]{4}|[0-9]{3}[a-z]{1}[0-9]{3}|[0-9]{4}[a-z]{1}[0-9]{2}|[0-9]{5}[a-z]{1}[0-9]{1}|[0-9]{6}[a-z]{1}/i','message'=>'Неправильно введен номер дрона'],
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
            'name' => 'Name',
            'surname' => 'Surname',
            'thirdname' => 'Thirdname',
            'email' => 'Email',
            'drone_id' => 'Drone ID',
            'drone_reg_number' => 'Drone Reg Number',
            'date' => 'Date',
            'x_coords' => 'X Coords',
            'y_coords' => 'Y Coords',
            'created_at' => 'Created At',
        ];
    }

    public function getDrons(){
        return $this->hasOne(Drons::className(), ['id' => 'drone_id']);
    }
    
    public function getPhones(){
        return $this->hasOne(Phones::className(), ['uid' => 'id']);
    }

    public static function getIdFromDronRegNumber($DronRegNumber){
		return FindDrons::find()->where(['drone_reg_number'=>$DronRegNumber])->one()['id'];
	}

    public static function getOneWithDrone($id){

        $users = FindDrons::find()->where(['`find_drons`.`id`'=> $id])->joinWith(['drons','phones'])->one();
                    
        // $users = FindDrons::find()
        //         ->where(['`find_drons`.`id`'=> $id])
        //         ->with('drons')
        //         //->asArray()
        //         ->all();
        //var_dump($users);
        return $users;
        // $query = \yii\db\Query;
        // $query->select('*')
        // ->from('`find_drons`')
        // ->where(['id'=>$id])
        // ->leftJoin('`drons`', '`find_drons`.`drone_id` = `drons`.`id`')
        // ->one()
        // $command = $query->createCommand();
        // $resp = $command->queryAll();
        // var_dump($resp);die;
    }
	
}
