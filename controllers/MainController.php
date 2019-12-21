<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\FindedDroneForm;
use app\models\LostedDroneForm;
use app\models\Drons;
use yii\helpers\ArrayHelper;
use app\models\PhoneForm;

class MainController extends Controller
{
    public function actionIndex()
    {
    	$FindedDroneForm = new FindedDroneForm();
        $LostedDroneForm = new LostedDroneForm();
        $PhoneFrom = new PhoneForm();
        $drons = Drons::find()->all();

        $items = ArrayHelper::map($drons, 'id', 'model');

        $params = [
            'prompt' => 'Укажите ваш дрон'
        ];


        // if ($model->load(Yii::$app->request->post()) && $model->validate()) {
        //     // данные в $model удачно проверены

        //     // делаем что-то полезное с $model ...
 
        //     return $this->render('main', ['model' => $model]);
        // } else {
        //     // либо страница отображается первый раз, либо есть ошибка в данных
        //     return $this->render('entry', ['model' => $model]);
        // }

        $values=[

            'FindedDroneForm' => $LostedDroneForm,
            'LostedDroneForm' => $FindedDroneForm,
            'PhoneForm' => $PhoneFrom,
            'items' => $items,
            'params' => $params

        ];

        return $this->render('index', $values);
    }
}