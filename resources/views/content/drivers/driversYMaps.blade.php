<div id="map-wrapper" class="card">
    <div class="card-content">
        <div id="drivers_ymap"></div>
    </div>
</div>
@push('vue')
    <script>
        let driversMapVue = new Vue({
            el: "#map-wrapper",
            data: function () {
                return this.initialState();
            },
            methods: {
                initialState() {
                    return {
                        driverMap: undefined,
                    }
                },
                prepareDriverMapObjects: function (objects) {
                    let center = [55.586171, 37.740881];
                    let zoom = 16;

                    if (driversMapVue.driverMap !== undefined) {
                        center = driversMapVue.driverMap.getCenter();
                        zoom = driversMapVue.driverMap.getZoom();
                        driversMapVue.driverMap.destroy();
                    }

                    driversMapVue.driverMap = new ymaps.Map("drivers_ymap", {
                        center: center,
                        zoom: zoom
                    });

                    $.each(objects, function (key, object) {
                        var myCollection = new ymaps.GeoObjectCollection();
                        // Добавим метку красного цвета.
                        var myPlacemark = new ymaps.Placemark([object.lat, object.lon], {
                            balloonContent: object.name,
                            iconCaption: object.name,
                        }, {
                            preset: 'islands#icon',
                            iconColor: '#ff0000'
                        });
                        myCollection.add(myPlacemark);

                        driversMapVue.driverMap.geoObjects.add(myCollection);
                    });
                },
                initMap: function () {
                    axios.get('/axios/drivers/driversPoints', {}, {
                        headers: {
                            Accept: 'application/json',
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        }
                    }).then(response => {
                        ymaps.ready(function () {
                            driversMapVue.prepareDriverMapObjects(response.data)
                        });
                    }).catch(e => {
                        console.log('Error!', e.message);
                    });
                },
            },
            mounted() {
                this.initMap();
                setTimeout(this.initMap, 30 * 1000);
            }
        });
    </script>
@endpush