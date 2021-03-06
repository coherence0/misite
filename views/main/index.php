<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use kartik\date\DatePicker;
use yii\widgets\Pjax;

?>
<div class="box">
    <div class="img-container img-one" id="find">
        <div class="img-container__item black__bg white">
            <h2>Я нашел<br> дрон</h2>
            <p>Кликните на дрон и заполните форму, и мы отправим ваши данные владельцу дрона!</p>
            <div class="img-container__item--image find"></div>
        </div>

    </div>
    <div class="img-container form">
        <div class="box__item phone">
            <p id='output'></p>
            <?php $findPhoneForm = ActiveForm::begin([
                'id' => 'findedDronePhoneForm',
                'action' => '/main/confirm',
                'method' => 'post',
                'enableAjaxValidation' => false,
                'options' => ['class' => ' hidden'],
            ]); ?>

            <?= $findPhoneForm->field($PhoneForm, 'phone')->label('Телефон')?>

            <?= Html::submitButton('Подтвердить', ['class' => 'btn red__bg', 'name' => 'approve-button', 'id' => 'phoneConfirmBtn']) ?>

            <?php ActiveForm::end(); ?>
        </div>
        <div class="box__item hidden" id="find_form">


            <?php $FindForm = ActiveForm::begin([
                'options' => ['id' => 'findedDroneForm'],
                'fieldConfig' => ['options' => ['class' => 'form__field']],
                'validateOnChange'=>'true'
            ]); ?>

            <?= $FindForm->field($FindedDroneForm, 'xCoords')->hiddenInput(['value' => '0', 'id' => 'findX'],)->label(false) ?>

            <?= $FindForm->field($FindedDroneForm, 'yCoords')->hiddenInput(['value' => '0', 'id' => 'findY'])->label(false) ?>

            <?= $FindForm->field($FindedDroneForm, 'name_surname')->label('Имя и Фамилия') ?>

            <?= $FindForm->field($FindedDroneForm, 'thirdname')->label('Отчество') ?>

            <?= $FindForm->field($FindedDroneForm, 'drone_reg_number', ['enableAjaxValidation' => true,'labelOptions'=>['data-toggle'=>'tooltip', 'title'=>'Кликните для подсказки', 'data-placement'=>'right', 'id'=>'drone_reg_number_input']])->label('Учетный номер дрона') ?>

            <?= $FindForm->field($FindedDroneForm, 'dron')->label('Марка найденного дрона')->dropDownList($items, $params) ?>

            <?= $FindForm->field($FindedDroneForm, 'drone_serial_number', ['enableAjaxValidation' => true, 'labelOptions'=>['data-toggle'=>'tooltip', 'title'=>'Кликните для подсказки', 'data-placement'=>'right', 'id'=>'drone_serial_number_input']])->label('Серийный номер дрона') ?>


            <?= $FindForm->field($FindedDroneForm, 'email')->label('E-mail')->input('email') ?>

            <?= $FindForm->field($FindedDroneForm, 'verificationcode', ['enableAjaxValidation' => true])->label('Код из СМС') ?>

            <?= $FindForm->field($FindedDroneForm, 'date')->label('Дата')->widget(DatePicker::classname(), [
                'options' => ['placeholder' => 'Введите дату когда вы нашли дрон'],
                'value' => '01/29/2014',
                'language' => 'ru',
                'type' => DatePicker::TYPE_COMPONENT_APPEND,
                'pickerIcon' => '<i class="fa fa-calendar-o" aria-hidden="true"></i>',
                'removeIcon' => '<i class="fa fa-calendar-times-o" aria-hidden="true"></i>',
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd'
                ]

            ]); ?>


            <div class="box__item__footer">
                <div id="mapFind"></div>


                <?= $FindForm->field($FindedDroneForm, 'iAgree')->checkbox()->label('Я согласен с обработкой персональных данных.') ?>
                <p id="userReq">Подробнее...</p>
                <?= Html::submitButton('Подтвердить', ['class' => 'btn box__button red__bg', 'name' => 'login-button']) ?>
            </div>
            <?php ActiveForm::end(); ?>
            <?php //echo 'Testing for ' . Html::tag('span', 'tooltip', [
            //'title'=>'This is a test tooltip',
            //'data-toggle'=>'tooltip',
            //'style'=>'text-decoration: underline; cursor:pointer;'
            //]);?>
        </div>
        <div class="box__item hidden" id="lost_form">

            <?php $LostForm = ActiveForm::begin([
                'options' => ['id' => 'lostedDroneForm'],
                'fieldConfig' => ['options' => ['class' => 'form__field']],
            ]); ?>

            <?= $LostForm->field($LostedDroneForm, 'xCoords')->hiddenInput(['value' => '0', 'id' => 'lostX'])->label(false) ?>

            <?= $LostForm->field($LostedDroneForm, 'yCoords')->hiddenInput(['value' => '0', 'id' => 'lostY'])->label(false) ?>

            <?= $LostForm->field($LostedDroneForm, 'name_surname')->label('Имя') ?>

            <?= $LostForm->field($LostedDroneForm, 'thirdname')->label('Отчество') ?>

            <?= $LostForm->field($LostedDroneForm, 'drone_reg_number', ['enableAjaxValidation' => true, 'labelOptions'=>['data-toggle'=>'tooltip', 'title'=>'Кликните для подсказки', 'data-placement'=>'right', 'id'=>'drone_lost_reg_number_input']])->label('Учетный номер дрона') ?>

            <?= $LostForm->field($LostedDroneForm, 'dron')->label('Марка найденного дрона')->dropDownList($items, $params) ?>

            <?= $LostForm->field($LostedDroneForm, 'drone_serial_number', ['enableAjaxValidation' => true,'labelOptions'=>['data-toggle'=>'tooltip', 'title'=>'Кликните для подсказки', 'data-placement'=>'right', 'id'=>'drone_lost_serial_number_input']])->label('Серийный номер дрона') ?>
            <?= $LostForm->field($LostedDroneForm, 'email')->label('E-mail')->input('email') ?>

            <?= $LostForm->field($LostedDroneForm, 'verificationcode', ['enableAjaxValidation' => true])->label('Код из СМС') ?>

            <?= $LostForm->field($LostedDroneForm, 'date')->label('Дата')->widget(DatePicker::classname(), [
                'options' => ['placeholder' => 'Введите дату когда вы потеряли дрон'],
                'value' => '01/29/2014',
                'language' => 'ru',
                'type' => DatePicker::TYPE_COMPONENT_APPEND,
                'pickerIcon' => '<i class="fa fa-calendar-o" aria-hidden="true"></i>',
                'removeIcon' => '<i class="fa fa-calendar-times-o" aria-hidden="true"></i>',
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd'
                ]

            ]); ?>

            <din class="box__item__footer">
                <div id="mapLost"></div>
                <?= $LostForm->field($LostedDroneForm, 'iAgree')->checkbox()->label('Я согласен с обработкой персональных данных.') ?>
                <p id="userRe">Подробнее...</p>
                <?= Html::submitButton('Подтвердить', ['class' => 'btn box__button red__bg', 'name' => 'login-button']) ?>
            </din>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
    <div class="img-container img-two" id="lost">
        <div class="img-container__item white__bg black">
            <h2>Я потерял<br> дрон</h2>
            <p>Кликните на дрон и заполните форму, и мы отправим вам данные человека нашедшего ваш дрона!</p>
            <div class="img-container__item--image lost"></div>
        </div>
    </div>
</div>
<footer class="footer">
    <div class="row">
        <div class="col ">
            <p class="pull-left">&copy; FindDrone <?= date('Y') ?></p>
        </div>
        <div class="col right">
            <div class="pull-right">
                <a class="fab fa-vk fa-2x" href="https://vk.com/club54998404" style="text-decoration: none;"></a>
                <a class="fab fa-twitter fa-2x" href="https://twitter.com/ATM_Corporation" style="text-decoration: none;"></a>
                <a class="fab fa-facebook-f fa-2x" href="https://www.facebook.com/gkorvd" style="text-decoration: none;"></a>
                <a class="fab fa-youtube fa-2x" href="https://www.youtube.com/user/gkovd/" style="text-decoration: none;"></a>
                <a class="fab fa-instagram fa-2x" href="https://www.instagram.com/gkovd/" style="text-decoration: none;"></a>
            </div>
        </div>
    </div>
</footer>
<!-- Dron reg Modal -->
<div class="modal fade" id="regNumberModel" tabindex="-1" role="dialog" aria-labelledby="regNumberModelCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="regNumberModelLongTitle">Где найти регистрационный номер дрона?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                А его не найти(
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="regSerialModel" tabindex="-1" role="dialog" aria-labelledby="regSerialModelCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="regSerialModelLongTitle">Где найти серийный номер дрона?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                А его не найти(
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="userR" tabindex="-1" role="dialog" aria-labelledby="regSerialModelCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="regSerialModelLongTitle">Тут что то будет?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Или нет(
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>