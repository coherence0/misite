$('document').ready(function() {

})
var mapFind = null;
var mapLost = null;
var coords;
ymaps.ready(function() {
    ymaps.geolocation.get().then(function(res) {
        coords = res;
        var mapContainerLost = $('#mapLost'),
                boundsLost = res.geoObjects.get(0).properties.get('boundedBy'),
                // Рассчитываем видимую область для текущей положения пользователя.
                mapStateLost = ymaps.util.bounds.getCenterAndZoom(
                    boundsLost,
                    [mapContainerLost.width(), mapContainerLost.height()]
                );
            createSecondMap(mapStateLost);
            var mapContainerFind = $('#mapFind'),
                boundsFind = res.geoObjects.get(0).properties.get('boundedBy'),
                // Рассчитываем видимую область для текущей положения пользователя.
                mapStateFind = ymaps.util.bounds.getCenterAndZoom(
                    boundsFind,
                    [mapContainerFind.width(), mapContainerFind.height()]
                );
            createFirstMap(mapStateFind);
        $('#find').on('click', function() {
            var mapContainerFind = $('#mapFind'),
                boundsFind = res.geoObjects.get(0).properties.get('boundedBy'),
                // Рассчитываем видимую область для текущей положения пользователя.
                mapStateFind = ymaps.util.bounds.getCenterAndZoom(
                    boundsFind,
                    [mapContainerFind.width(), mapContainerFind.height()]
                );
            createFirstMap(mapStateFind);
        });
        $('#lost').on('click', function() {
            var mapContainerLost = $('#mapLost'),
                boundsLost = res.geoObjects.get(0).properties.get('boundedBy'),
                // Рассчитываем видимую область для текущей положения пользователя.
                mapStateLost = ymaps.util.bounds.getCenterAndZoom(
                    boundsLost,
                    [mapContainerLost.width(), mapContainerLost.height()]
                );
            createSecondMap(mapStateLost);
        });
    }, function(e) {
        $('#find').one('click', createFirstMap({
            center: [55.751574, 37.573856],
            zoom: 2
        }));
        $('#lost').one('click', createSecondMap({
            center: [55.751574, 37.573856],
            zoom: 2
        }));
    })

    function createFirstMap(state) {
        if (mapFind == null) {
            mapFind = new ymaps.Map('mapFind', state);
            mapFind.events.add('click', function(e) {
                // Получение координат щелчка
                var coords = e.get('coords');
                var x = coords[0];
                var y = coords[1];
                findX.value = x;
                findY.value = y;
                mapFind.geoObjects.removeAll();
                mapFind.geoObjects.add(new ymaps.Placemark([x, y], {
                    balloonContent: '<strong>Я нашел дрон здесь</strong>'
                }, {
                    preset: 'islands#icon',
                    iconColor: '#0095b6'
                }))
            });
        } else {
            setTimeout(function() {
                boundsFind = coords.geoObjects.get(0).properties.get('boundedBy');
                mapFind.setBounds(boundsFind);
            }, 500);
        }

    };

    function createSecondMap(state) {
        if (mapLost == null) {
            mapLost = new ymaps.Map('mapLost', state);
            mapLost.events.add('click', function(e) {
                // Получение координат щелчка
                var coords = e.get('coords');
                var x = coords[0];
                var y = coords[1];
                lostX.value = x;
                lostY.value = y;
                mapLost.geoObjects.removeAll();
                mapLost.geoObjects.add(new ymaps.Placemark([x, y], {
                    balloonContent: '<strong>Я потерял дрон здесь</strong>'
                }, {
                    preset: 'islands#icon',
                    iconColor: '#0095b6'
                }))
            });
        } else {
            setTimeout(function() {
                boundsLost = coords.geoObjects.get(0).properties.get('boundedBy');
                mapLost.setBounds(boundsLost);
            }, 500);
        }
    }
})