<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use kartik\date\DatePicker;

?>
<div class="container">
  <div class="row">
    <div class="col">
      <?php $FindForm = ActiveForm::begin(['id' => 'FindedDroneForm']); 
                ?>

                <?= $FindForm->field($FindedDroneForm, 'xCoords')->hiddenInput(['value' => '0', 'id' => 'findX'],)->label(false)?>

                <?= $FindForm->field($FindedDroneForm, 'yCoords')->hiddenInput(['value' => '0', 'id' => 'findY'])->label(false)?>

                <?= $FindForm->field($FindedDroneForm, 'name')->label('Имя') ?>

                <?= $FindForm->field($FindedDroneForm, 'surname')->label('Фамилия') ?>

                <?= $FindForm->field($FindedDroneForm, 'thirdname')->label('Отчество') ?>

                <?= $FindForm->field($FindedDroneForm, 'dron')->label('Марка найденного дрона')->dropDownList($items, $params) ?>

                <?= $FindForm->field($FindedDroneForm, 'idetificalNumber')->passwordInput()->label('Идентификационный номер дрона') ?>

                <?= $FindForm->field($FindedDroneForm, 'email')->label('E-mail')->input('email') ?>

                <?php $phoneForm = ActiveForm::begin(['id' => 'FindedDroneForm']); 
                ?>

                <?= $phoneForm->field($PhoneForm, 'phone')->label('Телефон')?>

                <?= Html::submitButton('Подтвердить', ['class' => 'btn btn-primary', 'name' => 'approve-button']) ?>
 
                <?php ActiveForm::end(); ?>

                <?= $FindForm->field($FindedDroneForm, 'verificationcode')->label('Код из смс')?>

                <?= $FindForm->field($FindedDroneForm, 'date')->label('Дата')->widget(DatePicker::classname(), [
                'options' => ['placeholder' => 'Введите дату когды вы нашли дрон'],
                'value' => '01/29/2014',
                'language' => 'ru',
                'type' => DatePicker::TYPE_COMPONENT_APPEND,
                'pickerIcon' => '<i class="fa fa-calendar-o" aria-hidden="true"></i>',
                'removeIcon' => '<i class="fa fa-calendar-times-o" aria-hidden="true"></i>',
                'pluginOptions' => [
                    'autoclose'=>true,
                    'format' => 'dd/mm/yyyy'
                ]
                
                ]);?>

                <div id="mapFind" style="width: 300px; height: 200px"></div>

                <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
 
                <?php ActiveForm::end(); ?>
    </div>
    <div class="col">
        <?php $LostForm = ActiveForm::begin(['id' => 'LostedDroneForm']); 
                ?>

                <?= $LostForm->field($LostedDroneForm, 'xCoords')->hiddenInput(['value' => '0', 'id' => 'lostX'])->label(false)?>

                <?= $LostForm->field($LostedDroneForm, 'yCoords')->hiddenInput(['value' => '0', 'id' => 'lostY'])->label(false)?>

                <?= $LostForm->field($LostedDroneForm, 'name')->label('Имя') ?>

                <?= $LostForm->field($LostedDroneForm, 'surname')->label('Фамилия') ?>

                <?= $LostForm->field($LostedDroneForm, 'thirdname')->label('Отчество') ?>

                <?= $LostForm->field($LostedDroneForm, 'dron')->label('Марка потерянного дрона')->dropDownList($items, $params) ?>

                <?= $LostForm->field($LostedDroneForm, 'idetificalNumber')->passwordInput()->label('Идентификационный номер дрона') ?>

                <?= $LostForm->field($LostedDroneForm, 'email')->label('E-mail')->input('email') ?>

                <?php $phoneForm = ActiveForm::begin(['id' => 'LostedDroneForm']); 
                ?>

                <?= $phoneForm->field($PhoneForm, 'phone')->label('Телефон')?>

                <?= Html::submitButton('Подтвердить', ['class' => 'btn btn-primary', 'name' => 'approve-button']) ?>
 
                <?php ActiveForm::end(); ?>

                <?= $LostForm->field($LostedDroneForm, 'verificationcode')->label('Код из смс')?>

                <?= $LostForm->field($LostedDroneForm, 'date')->label('Дата')->widget(DatePicker::classname(), [
                'options' => ['placeholder' => 'Введите дату когды вы потеряли дрон'],
                'value' => '01/29/2014',
                'language' => 'ru',
                'type' => DatePicker::TYPE_COMPONENT_APPEND,
                'pickerIcon' => '<i class="fa fa-calendar-o" aria-hidden="true"></i>',
                'removeIcon' => '<i class="fa fa-calendar-times-o" aria-hidden="true"></i>',
                'pluginOptions' => [
                    'autoclose'=>true,
                    'format' => 'dd/mm/yyyy'
                ]
                
                ]);?>


                <div id="mapLost" style="width: 300px; height: 200px"></div>

                <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
 
                <?php ActiveForm::end(); ?>
    </div>
  </div>
</div>

