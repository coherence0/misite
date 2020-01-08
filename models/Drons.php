<?php

namespace app\models;

use Yii;
use app\models\FindDrons;

/**
 * This is the model class for table "drons".
 *
 * @property int $id
 * @property string $model
 */
class Drons extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'drons';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['model'], 'required'],
            [['model'], 'string', 'max' => 65],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'model' => 'Model',
        ];
    }

    // public function getFindDrons(){
    //     return $this->hasOne(FindDrons::className(), ['dron_id' => 'id']);
    // }
}
