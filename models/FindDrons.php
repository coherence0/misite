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
            [['name', 'surname', 'thirdname', 'email', 'drone_id', 'drone_reg_number', 'date', 'x_coords', 'y_coords', 'created_at'], 'required'],
            [['drone_id'], 'integer'],
            [
                'date',
                'date',
                'format'=>'php:Y-m-d',
            ],
            ['thirdname', 'default', 'value'=>'нет'],
            [['name', 'surname', 'thirdname'], 'string', 'max' => 30],
            [['email'], 'string', 'max' => 255],
            [['drone_reg_number'], 'string', 'max' => 7],
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
