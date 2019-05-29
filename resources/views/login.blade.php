<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>SmaaT - Login</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link href="/css/font.css" rel="stylesheet" type="text/css">
        <!-- Styles -->
        
        <link href="https://static.neshan.org/sdk/leaflet/1.4.0/leaflet.css" rel="stylesheet" type="text/css">
        <script src="https://static.neshan.org/sdk/leaflet/1.4.0/leaflet.js" type="text/javascript"></script>
    </head>
    <body>
        <div id="map" style="width: 600px; height: 450px; background: #eee; border: 2px solid #aaa;"></div>
        <script type="text/javascript">

            var myMap = new L.Map('map', {
                key: 'web.8HU2Ho1RdkaEAT79wJPPdc1ddkgRH0iPIcSqBThP',
                maptype: 'dreamy',
                poi: true,
                traffic: false,
                center: [36.2995, 59.5568],
                zoom: 15
            });

            // var imageUrl = 'http://www.lib.utexas.edu/maps/historical/newark_nj_1922.jpg',
            //     imageBounds = [[36.2996, 59.5568], [36.2896, 59.5668]];
            // L.imageOverlay(imageUrl, imageBounds).addTo(myMap);

            
            var marker = L.circleMarker([36.2996, 59.5568], {
                draggable: true,
                title: 'یک سفارش'
                // icon: greenIcon,
                // dragend: (e) console.console.log(e)
                
            }).addTo(myMap)
            
            marker.bindPopup("<h2>سفارش شماره یک</h2><p>اطلاعات سفارش را مشاهده کنید</p><img width='40' src='/maps-and-flags.png' />")

            marker.addEventListener("click", (e) => {
                marker.openPopup();
                console.log( e );
            });

            // marker.move ( function(e) {
            //     console.log( e )
            // } );

            // marker.move = 

            // var circle = L.circle([36.2995, 59.5568], {
            //     color: 'red',
            //     fillColor: '#f03',
            //     fillOpacity: 0.3,
            //     radius: 500
            // }).addTo(myMap);

            // var polygon = L.polygon([
            //     [36.2935, 59.5528],
            //     [36.2925, 59.5568],
            //     [36.2995, 59.5538]
            // ]).addTo(myMap);

            // marker.bindPopup("<b>Hello world!</b><br>I am a popup.").openPopup();

            // function onMapClick(e) {
            //     var marker = L.marker([e.latlng.lat, e.latlng.lng]).addTo(myMap);
            //     console.log( e )
            // }

            // myMap.on('click', onMapClick)
        </script>

        <div id="app">
            <Login></Login>
        </div>

        <script src="{{ asset('js/login.js') }}"></script>
    </body>
</html>