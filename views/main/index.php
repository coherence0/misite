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
    <div class="img-container img-one">
<!--        --><?php //Pjax::begin(); ?>
<!---->
<!--                --><?php //if(!empty($status)): ?>
<!--                    <p><code>--><?//=$status?><!--</code></p>-->
<!--                --><?php //endif; ?>
<!---->
<!--                --><?php //$findPhoneForm = ActiveForm::begin(['id' => 'FindedDronePhoneForm', 'options'=>['data-pjax' => true]]);?>
<!---->
<!--                --><?//= $findPhoneForm->field($PhoneForm, 'phone')->label('Телефон')?>
<!---->
<!--                --><?//= Html::submitButton('Подтвердить', ['class' => 'btn btn-primary', 'name' => 'approve-button']) ?>
<!-- -->
<!--                --><?php //ActiveForm::end(); ?>
<!--                    -->
<!--        --><?php //Pjax::end(); ?>
      <?php $FindForm = ActiveForm::begin(['id' => 'FindedDroneForm']); ?>

                <?= $FindForm->field($FindedDroneForm, 'xCoords')->hiddenInput(['value' => '0', 'id' => 'findX'],)->label(false)?>

                <?= $FindForm->field($FindedDroneForm, 'yCoords')->hiddenInput(['value' => '0', 'id' => 'findY'])->label(false)?>

                <?= $FindForm->field($FindedDroneForm, 'name')->label('Имя') ?>

                <?= $FindForm->field($FindedDroneForm, 'surname')->label('Фамилия') ?>

                <?= $FindForm->field($FindedDroneForm, 'thirdname')->label('Отчество') ?>

                <?= $FindForm->field($FindedDroneForm, 'dron')->label('Марка найденного дрона')->dropDownList($items, $params) ?>

                <?= $FindForm->field($FindedDroneForm, 'idetificalNumber')->label('Идентификационный номер дрона') ?>


                <?= $FindForm->field($FindedDroneForm, 'email')->label('E-mail')->input('email') ?>

                <?= $FindForm->field($FindedDroneForm, 'verificationcode', ['enableAjaxValidation' => true])->label('Код из СМС')?>

                <?= $FindForm->field($FindedDroneForm, 'date')->label('Дата')->widget(DatePicker::classname(), [
                'options' => ['placeholder' => 'Введите дату когды вы нашли дрон'],
                'value' => '01/29/2014',
                'language' => 'ru',
                'type' => DatePicker::TYPE_COMPONENT_APPEND,
                'pickerIcon' => '<i class="fa fa-calendar-o" aria-hidden="true"></i>',
                'removeIcon' => '<i class="fa fa-calendar-times-o" aria-hidden="true"></i>',
                'pluginOptions' => [
                    'autoclose'=>true,
                    'format' => 'yyyy-mm-dd'
                ]
                
                ]);?>

                <div id="mapFind"></div>

                <?= Html::submitButton('Login', ['class' => 'btn btn-primary box__button', 'name' => 'login-button']) ?>
 
                <?php ActiveForm::end(); ?>
    </div>
    <div class="img-container img-two">
<!--        --><?php //Pjax::begin(); ?>
<!---->
<!--                --><?php //if(!empty($status)): ?>
<!--                    <p><code>--><?//=$status?><!--</code></p>-->
<!--                --><?php //endif; ?>
<!---->
<!--                --><?php //$LostedphoneForm = ActiveForm::begin(['id' => 'LostedDronePhoneForm', 'options'=>['data-pjax' => true]]); ?>
<!---->
<!--                --><?//= $LostedphoneForm->field($PhoneForm, 'phone')->label('Телефон')?>
<!---->
<!--                --><?//= Html::submitButton('Подтвердить', ['class' => 'btn btn-primary', 'name' => 'approve-button']) ?>
<!-- -->
<!--                --><?php //ActiveForm::end(); ?>
<!--                    -->
<!--        --><?php //Pjax::end(); ?>

        <?php $LostForm = ActiveForm::begin(['id' => 'LostedDroneForm']); ?>

                <?= $LostForm->field($LostedDroneForm, 'xCoords')->hiddenInput(['value' => '0', 'id' => 'lostX'])->label(false)?>

                <?= $LostForm->field($LostedDroneForm, 'yCoords')->hiddenInput(['value' => '0', 'id' => 'lostY'])->label(false)?>

                <?= $LostForm->field($LostedDroneForm, 'name')->label('Имя') ?>

                <?= $LostForm->field($LostedDroneForm, 'surname')->label('Фамилия') ?>

                <?= $LostForm->field($LostedDroneForm, 'thirdname')->label('Отчество') ?>

                <?= $LostForm->field($LostedDroneForm, 'dron')->label('Марка потерянного дрона')->dropDownList($items, $params) ?>

                <?= $LostForm->field($LostedDroneForm, 'idetificalNumber')->label('Идентификационный номер дрона') ?>

                <?= $LostForm->field($LostedDroneForm, 'email')->label('E-mail')->input('email') ?>

                <?= $LostForm->field($LostedDroneForm, 'verificationcode',['enableAjaxValidation' => true])->label('Код из СМС')?>

                <?= $LostForm->field($LostedDroneForm, 'date')->label('Дата')->widget(DatePicker::classname(), [
                'options' => ['placeholder' => 'Введите дату когды вы потеряли дрон'],
                'value' => '01/29/2014',
                'language' => 'ru',
                'type' => DatePicker::TYPE_COMPONENT_APPEND,
                'pickerIcon' => '<i class="fa fa-calendar-o" aria-hidden="true"></i>',
                'removeIcon' => '<i class="fa fa-calendar-times-o" aria-hidden="true"></i>',
                'pluginOptions' => [
                    'autoclose'=>true,
                    'format' => 'yyyy-mm-dd'
                ]
                
                ]);?>


                <div id="mapLost"></div>

                <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
 
                <?php ActiveForm::end(); ?>
    </div>
</div>

