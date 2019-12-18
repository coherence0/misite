<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\FindedDroneForm;
use app\models\LostedDroneForm;

class MainController extends Controller
{
    public function actionIndex()
    {
    	$FindedDroneForm = new FindedDroneForm();
        $LostedDroneForm = new LostedDroneForm();

        // if ($model->load(Yii::$app->request->post()) && $model->validate()) {
        //     // данные в $model удачно проверены

        //     // делаем что-то полезное с $model ...
 
        //     return $this->render('main', ['model' => $model]);
        // } else {
        //     // либо страница отображается первый раз, либо есть ошибка в данных
        //     return $this->render('entry', ['model' => $model]);
        // }
        return $this->render('index', ['FindedDroneForm' => $LostedDroneForm,'LostedDroneForm'=>$FindedDroneForm]);
    }
}