<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\EntryForm;
use app\models\signUp;

use yii\helpers\Url;
class AuthController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public $layout = 'NO_LAY';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
        return Yii::$app->response->redirect(Url::to('/web/admin/drons'));
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionRegister(){
        Yii::$app->user->logout();
        return $this->goHome();
        // $user = new signUp;
        // $user->username = 'admin';
        // $user->email = 'null';
        // $user->password = Yii::$app->getSecurity()->generatePasswordHash('12345');
        // $user->isAdmin = '1';
        // $user->save();
        //echo (Yii::$app->getSecurity()->generatePasswordHash('12345'));

    }


}
