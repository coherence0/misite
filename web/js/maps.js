$('#find').one('click',function(){
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
        createFirstMap(mapState);
        //createSecondMap(mapLostState);
    }, function (e) {
        // Если местоположение невозможно получить, то просто создаем карту.
        createFirstMap({
            center: [55.751574, 37.573856],
            zoom: 2
        });
    });
    
    function createFirstMap (state) {
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
            balloonContent: 'цвет <strong>Я нашел дрон здесь</strong>'
        }, {
            preset: 'islands#icon',
            iconColor: '#0095b6'
        }))
        });
    }
    function createSecondMap (state) {
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
            balloonContent: 'цвет <strong>Я потерял дрон здесь</strong>'
        }, {
            preset: 'islands#icon',
            iconColor: '#0095b6'
        }))
        });
    }
});    
})
$('#lost').one('click',function(){
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
        createSecondMap(mapState);
        //createSecondMap(mapLostState);
    }, function (e) {
        // Если местоположение невозможно получить, то просто создаем карту.
        createFirstMap({
            center: [55.751574, 37.573856],
            zoom: 2
        });
    });
    function createSecondMap (state) {
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
            balloonContent: 'цвет <strong>Я потерял дрон здесь</strong>'
        }, {
            preset: 'islands#icon',
            iconColor: '#0095b6'
        }))
        });
    }
});    
})