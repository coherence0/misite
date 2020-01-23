	ymaps.ready(function () {
		ymaps.geolocation.get().then(function (res) {
			$('#find').one('click',function(){
				var mapContainerFind = $('#mapFind'),
            	boundsFind = res.geoObjects.get(0).properties.get('boundedBy'),
             	// Рассчитываем видимую область для текущей положения пользователя.
             	mapStateFind = ymaps.util.bounds.getCenterAndZoom(
               		boundsFind,
                	[mapContainerFind.width(), mapContainerFind.height()]
             	);
             	createFirstMap(mapStateFind);
			});
			$('#lost').one('click',function(){
				var mapContainerLost = $('#mapLost'),
            	boundsLost = res.geoObjects.get(0).properties.get('boundedBy'),
             	// Рассчитываем видимую область для текущей положения пользователя.
             	mapStateLost = ymaps.util.bounds.getCenterAndZoom(
               		boundsLost,
                	[mapContainerLost.width(), mapContainerLost.height()]
             	);
             	createSecondMap(mapStateLost);
			});
		}, function (e){
			$('#find').one('click',createFirstMap({
            	center: [55.751574, 37.573856],
            	zoom: 2
        	}));
        	$('#lost').one('click',createSecondMap({
            	center: [55.751574, 37.573856],
            	zoom: 2
        	}));
		})

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
            		balloonContent: '<strong>Я нашел дрон здесь</strong>'
        	}, {
            preset: 'islands#icon',
            iconColor: '#0095b6'
        		}))
        	});
    	};
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
            	balloonContent: '<strong>Я потерял дрон здесь</strong>'
        }, {
            preset: 'islands#icon',
            iconColor: '#0095b6'
        }))
        });
	}

})