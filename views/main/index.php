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
        <div class="img-container__item red">
            <h2>Я нашел<br> дрон</h2>
            <p>Кликните на дрон и заполните форму, и мы отправим ваши данные владельцу дрона!</p>
            <div class="img-container__item--image find"></div>
        </div>

    </div>
    <div class="img-container form">
        <div class="box__item phone">
            <?php $findPhoneForm = ActiveForm::begin([
                'id' => 'findedDronePhoneForm',
                'action' => '/main/confirm',
                'method' => 'post',
                'enableAjaxValidation' => false,
                'options' => ['class' => ' hidden'],
            ]); ?>

            <?= $findPhoneForm->field($PhoneForm, 'phone')->label('Телефон') ?>

            <?= Html::submitButton('Подтвердить', ['class' => 'btn red__bg', 'name' => 'approve-button', 'id' => 'phoneConfirmBtn']) ?>

            <?php ActiveForm::end(); ?>
        </div>
        <div class="box__item hidden" id="find_form">
            <p id='output'></p>

            <?php $FindForm = ActiveForm::begin([
                'options' => ['id' => 'findedDroneForm'],
                'fieldConfig' => ['options' => ['class' => 'form__field']],
            ]); ?>

            <?= $FindForm->field($FindedDroneForm, 'xCoords')->hiddenInput(['value' => '0', 'id' => 'findX'],)->label(false) ?>

            <?= $FindForm->field($FindedDroneForm, 'yCoords')->hiddenInput(['value' => '0', 'id' => 'findY'])->label(false) ?>

            <?= $FindForm->field($FindedDroneForm, 'name')->label('Имя') ?>

            <?= $FindForm->field($FindedDroneForm, 'surname')->label('Фамилия') ?>

            <?= $FindForm->field($FindedDroneForm, 'thirdname')->label('Отчество') ?>

            <?= $FindForm->field($FindedDroneForm, 'dron')->label('Марка найденного дрона')->dropDownList($items, $params) ?>

            <?= $FindForm->field($FindedDroneForm, 'idetificalNumber')->label('Учетный номер дрона') ?>


            <?= $FindForm->field($FindedDroneForm, 'email')->label('E-mail')->input('email') ?>

            <?= $FindForm->field($FindedDroneForm, 'verificationcode', ['enableAjaxValidation' => true])->label('Код из СМС') ?>

            <?= $FindForm->field($FindedDroneForm, 'date')->label('Дата')->widget(DatePicker::classname(), [
                'options' => ['placeholder' => 'Введите дату когды вы нашли дрон'],
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

                <?= Html::submitButton('Login', ['class' => 'btn box__button red__bg', 'name' => 'login-button']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
        <div class="box__item hidden" id="lost_form">

            <?php $LostForm = ActiveForm::begin([
                'options' => ['id' => 'lostedDroneForm'],
                'fieldConfig' => ['options' => ['class' => 'form__field']],
            ]); ?>

            <?= $LostForm->field($LostedDroneForm, 'xCoords')->hiddenInput(['value' => '0', 'id' => 'lostX'])->label(false) ?>

            <?= $LostForm->field($LostedDroneForm, 'yCoords')->hiddenInput(['value' => '0', 'id' => 'lostY'])->label(false) ?>

            <?= $LostForm->field($LostedDroneForm, 'name')->label('Имя') ?>

            <?= $LostForm->field($LostedDroneForm, 'surname')->label('Фамилия') ?>

            <?= $LostForm->field($LostedDroneForm, 'thirdname')->label('Отчество') ?>

            <?= $LostForm->field($LostedDroneForm, 'dron')->label('Марка потерянного дрона')->dropDownList($items, $params) ?>

            <?= $LostForm->field($LostedDroneForm, 'idetificalNumber')->label('Учетный номер дрона') ?>

            <?= $LostForm->field($LostedDroneForm, 'email')->label('E-mail')->input('email') ?>

            <?= $LostForm->field($LostedDroneForm, 'verificationcode', ['enableAjaxValidation' => true])->label('Код из СМС') ?>

            <?= $LostForm->field($LostedDroneForm, 'date')->label('Дата')->widget(DatePicker::classname(), [
                'options' => ['placeholder' => 'Введите дату когды вы потеряли дрон'],
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

                <?= Html::submitButton('Login', ['class' => 'btn box__button yellow__bg', 'name' => 'login-button']) ?>
            </din>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
    <div class="img-container img-two" id="lost">
        <div class="img-container__item blue">
            <h2>Я потерял<br> дрон</h2>
            <p>Кликните на дрон и заполните форму, и мы отправим вам данные человека нашедшего ваш дрона!</p>
            <div class="img-container__item--image lost"></div>
        </div>
    </div>
</div>
<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>
    </div>
</footer>