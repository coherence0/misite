<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
?>
<div class="container">
  <div class="row">
    <div class="col">
      <?php $FindForm = ActiveForm::begin(['id' => 'FindedDroneForm']); 
                ?>

                <?= $FindForm->field($FindedDroneForm, 'xCoords')->hiddenInput(['value' => '0'])->label(false)?>

                <?= $FindForm->field($FindedDroneForm, 'yCoords')->hiddenInput(['value' => '0'])->label(false)?>

                <?= $FindForm->field($FindedDroneForm, 'name')->label('Имя') ?>

                <?= $FindForm->field($FindedDroneForm, 'surname')->passwordInput()->label('Фамилия') ?>

                <?= $FindForm->field($FindedDroneForm, 'thirdname')->passwordInput()->label('Отчество') ?>

                <?= $FindForm->field($FindedDroneForm, 'idetificalNumber')->passwordInput()->label('Идентификационный номер дрона') ?>

                <?= $FindForm->field($FindedDroneForm, 'phone')->passwordInput()->label('Телефон') ?>

                <?= $FindForm->field($FindedDroneForm, 'email')->passwordInput()->label('E-mail')->input('email') ?>

                <?= $FindForm->field($FindedDroneForm, 'phone')->label('Телефон')?>

                <?= Html::submitButton('Approve', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>


                <?= $FindForm->field($FindedDroneForm, 'verificationcode')->label('Код из смс')?>

                <?= $FindForm->field($FindedDroneForm, 'date')->label('Дата')?>

                <div id="mapFind" style="width: 300px; height: 200px"></div>

                <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
 
                <?php ActiveForm::end(); ?>
    </div>
    <div class="col">
        <?php $LostForm = ActiveForm::begin(['id' => 'LostedDroneForm']); 
                ?>

                <?= $LostForm->field($LostedDroneForm, 'xCoords')->hiddenInput(['value' => '0'])->label(false)?>

                <?= $LostForm->field($LostedDroneForm, 'yCoords')->hiddenInput(['value' => '0'])->label(false)?>

                <?= $LostForm->field($LostedDroneForm, 'name')->label('Имя') ?>

                <?= $LostForm->field($LostedDroneForm, 'surname')->passwordInput()->label('Фамилия') ?>

                <?= $LostForm->field($LostedDroneForm, 'thirdname')->passwordInput()->label('Отчество') ?>

                <?= $LostForm->field($LostedDroneForm, 'idetificalNumber')->passwordInput()->label('Идентификационный номер дрона') ?>

                <?= $LostForm->field($LostedDroneForm, 'phone')->passwordInput()->label('Телефон') ?>

                <?= $LostForm->field($LostedDroneForm, 'email')->passwordInput()->label('E-mail')->input('email') ?>

                <?= $LostForm->field($LostedDroneForm, 'phone')->label('Телефон')?>

                <?= Html::submitButton('Approve', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>


                <?= $LostForm->field($LostedDroneForm, 'verificationcode')->label('Код из смс')?>

                <?= $LostForm->field($LostedDroneForm, 'date')->label('Дата')?>


                <div id="mapLost" style="width: 300px; height: 200px"></div>

                <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
 
                <?php ActiveForm::end(); ?>
    </div>
  </div>
</div>
<script type="text/javascript">
    // Функция ymaps.ready() будет вызвана, когда
    // загрузятся все компоненты API, а также когда будет готово DOM-дерево.
    ymaps.ready(init);
    function init(){
        // Создание карты.
        var findMap = new ymaps.Map("mapFind", {
            // Координаты центра карты.
            // Порядок по умолчанию: «широта, долгота».
            // Чтобы не определять координаты центра карты вручную,
            // воспользуйтесь инструментом Определение координат.
            center: [55.76, 37.64],
            // Уровень масштабирования. Допустимые значения:
            // от 0 (весь мир) до 19.
            zoom: 7

        });
        var lostMap = new ymaps.Map("mapLost", {
            // Координаты центра карты.
            // Порядок по умолчанию: «широта, долгота».
            // Чтобы не определять координаты центра карты вручную,
            // воспользуйтесь инструментом Определение координат.
            center: [55.76, 37.64],
            // Уровень масштабирования. Допустимые значения:
            // от 0 (весь мир) до 19.
            zoom: 7

        });

        findMap.events.add('click', function (e) {
    // Получение координат щелчка
        var coords = e.get('coords');
        var x = coords[0];
        var y = coords[1];
        findMap.geoObjects.add(new ymaps.Placemark([x,y], {
            balloonContent: 'цвет <strong>воды пляжа бонди</strong>'
        }, {
            preset: 'islands#icon',
            iconColor: '#0095b6'
        }))
        // console.log(coords);
        // alert(coords.join(', '));
        });

        lostMap.events.add('click', function (e) {
    // Получение координат щелчка
        var coords = e.get('coords');
        var x = coords[0];
        var y = coords[1];
        lostMap.geoObjects.add(new ymaps.Placemark([x,y], {
            balloonContent: 'цвет <strong>воды пляжа бонди</strong>'
        }, {
            preset: 'islands#icon',
            iconColor: '#0095b6'
        }))
        // console.log(coords);
        // alert(coords.join(', '));
        });

    }

</script>

<script type="text/javascript">

    

</script>