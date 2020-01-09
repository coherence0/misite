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
            [['name', 'surname', 'thirdname', 'email', 'drone_id', 'drone_reg_number', 'date', 'x_coords', 'y_coords', 'created_at'], 'required'],
            [['email'], 'string'],
            [['drone_id'], 'integer'],
            [['date'], 'safe'],
            [['name', 'surname', 'thirdname', 'x_coords', 'y_coords', 'created_at'], 'string', 'max' => 30],
            [['drone_reg_number'], 'string', 'max' => 7],
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

    public static function getIdFromDronRegNumber($DronRegNumber){
        return LostDrons::find()->where(['drone_reg_number'=>$DronRegNumber])->one()['id'];
    }
}
