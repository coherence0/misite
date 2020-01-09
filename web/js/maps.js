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
        console.log(1);
        console.error(e);
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
        fitMapToViewport();
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
        console.log(2);
        console.error(e);
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
        fitMapToViewport()
    }
});