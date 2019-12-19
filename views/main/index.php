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

                <?= $FindForm->field($FindedDroneForm, 'xCoords')->hiddenInput(['value' => '0', 'id' => 'findX'],)->label(false)?>

                <?= $FindForm->field($FindedDroneForm, 'yCoords')->hiddenInput(['value' => '0', 'id' => 'findY'])->label(false)?>

                <?= $FindForm->field($FindedDroneForm, 'name')->label('Имя') ?>

                <?= $FindForm->field($FindedDroneForm, 'surname')->label('Фамилия') ?>

                <?= $FindForm->field($FindedDroneForm, 'thirdname')->label('Отчество') ?>

                <?= $FindForm->field($FindedDroneForm, 'dron')->label('Марка потерянного дрона')->dropDownList($items, $params) ?>

                <?= $FindForm->field($FindedDroneForm, 'idetificalNumber')->passwordInput()->label('Идентификационный номер дрона') ?>

                <?= $FindForm->field($FindedDroneForm, 'phone')->label('Телефон') ?>

                <?= $FindForm->field($FindedDroneForm, 'email')->label('E-mail')->input('email') ?>

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

                <?= $LostForm->field($LostedDroneForm, 'xCoords')->hiddenInput(['value' => '0', 'id' => 'lostX'])->label(false)?>

                <?= $LostForm->field($LostedDroneForm, 'yCoords')->hiddenInput(['value' => '0', 'id' => 'lostY'])->label(false)?>

                <?= $LostForm->field($LostedDroneForm, 'name')->label('Имя') ?>

                <?= $LostForm->field($LostedDroneForm, 'surname')->passwordInput()->label('Фамилия') ?>

                <?= $LostForm->field($LostedDroneForm, 'thirdname')->passwordInput()->label('Отчество') ?>

                <?= $LostForm->field($LostedDroneForm, 'dron')->label('Марка потерянного дрона')->dropDownList($items, $params) ?>

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
ymaps.ready(function () {
    var map;
    ymaps.geolocation.get().then(function (res) {
        var mapContainer = $('#mapFind'),
            bounds = res.geoObjects.get(0).properties.get('boundedBy'),
            // Рассчитываем видимую область для текущей положения пользователя.
            mapState = ymaps.util.bounds.getCenterAndZoom(
                bounds,
                [mapContainer.width(), mapContainer.height()]
            );
        createMap(mapState);
    }, function (e) {
        // Если местоположение невозможно получить, то просто создаем карту.
        createMap({
            center: [55.751574, 37.573856],
            zoom: 2
        });
    });
    
    function createMap (state) {
        map = new ymaps.Map('mapFind', state);
        map.events.add('click', function (e) {
    // Получение координат щелчка
        var coords = e.get('coords');
        var x = coords[0];
        var y = coords[1];
        findX.value = x;
        findY.value = y;
        map.geoObjects.removeAll();
        map.geoObjects.add(new ymaps.Placemark([x,y], {
            balloonContent: 'цвет <strong>воды пляжа бонди</strong>'
        }, {
            preset: 'islands#icon',
            iconColor: '#0095b6'
        }))
        // console.log(coords);
        // alert(coords.join(', '));
        });
    }




});

ymaps.ready(function () {
    var map;
    ymaps.geolocation.get().then(function (res) {
        var mapContainer = $('#mapLost'),
            bounds = res.geoObjects.get(0).properties.get('boundedBy'),
            // Рассчитываем видимую область для текущей положения пользователя.
            mapState = ymaps.util.bounds.getCenterAndZoom(
                bounds,
                [mapContainer.width(), mapContainer.height()]
            );
        createMap(mapState);
    }, function (e) {
        // Если местоположение невозможно получить, то просто создаем карту.
        createMap({
            center: [55.751574, 37.573856],
            zoom: 2
        });
    });
    
    function createMap (state) {
        map = new ymaps.Map('mapLost', state);

        map.events.add('click', function (e) {
    // Получение координат щелчка
        var coords = e.get('coords');
        var x = coords[0];
        var y = coords[1];
        lostX.value = x;
        lostY.value = y;
        map.geoObjects.removeAll();
        map.geoObjects.add(new ymaps.Placemark([x,y], {
            balloonContent: 'цвет <strong>воды пляжа бонди</strong>'
        }, {
            preset: 'islands#icon',
            iconColor: '#0095b6'
        }))
        });
    }



});

</script>
