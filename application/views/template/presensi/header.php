<!doctype html>
<html>

<head>
    <!-- Required meta tags -->

    <meta name="viewport" content="width = device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=no;">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous">
    <!-- Favicon -->
    <link rel="shortcut icon" href="<?= base_url(); ?>assets/images/logo.png" type="image/x-icon">
    <!-- sweetalert2 -->
    <!-- <link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/sweetalert2/sweetalert2.css"> -->
    <!-- geolocation -->
    <script src="<?= base_url(); ?>assets/vendor/geolocation/geo.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>

    <title><?= $title; ?></title>

    <script>
        function initialize_map() {
            var myOptions = {
                zoom: 4,
                mapTypeControl: true,
                mapTypeControlOptions: {
                    style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
                },
                navigationControl: true,
                navigationControlOptions: {
                    style: google.maps.NavigationControlStyle.SMALL
                },
                mapTypeId: google.maps.MapTypeId.ROADMAP
            }
            map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
        }

        function initialize() {
            if (geo_position_js.init()) {
                document.getElementById('current').innerHTML = "Receiving...";
                geo_position_js.getCurrentPosition(show_position, function() {
                    document.getElementById('current').innerHTML = "Couldn't get location"
                }, {
                    enableHighAccuracy: true
                });
            } else {
                document.getElementById('current').innerHTML = "Functionality not available";
            }
        }

        function show_position(p) {
            var latitude = document.getElementById('latitude');
            var longitude = document.getElementById('longitude');

            latitude.value = p.coords.latitude.toFixed(4);
            longitude.value = p.coords.longitude.toFixed(4);

            document.getElementById('current').innerHTML = "latitude=" + p.coords.latitude.toFixed(4) + " longitude=" + p.coords.longitude.toFixed(4);

            var pos = new google.maps.LatLng(p.coords.latitude, p.coords.longitude);

            map.setCenter(pos);
            map.setZoom(14);

            var infowindow = new google.maps.InfoWindow({
                content: "<strong>yes</strong>"
            });

            var marker = new google.maps.Marker({
                position: pos,
                map: map,
                title: "You are here"
            });

            google.maps.event.addListener(marker, 'click', function() {
                infowindow.open(map, marker);
            });

        }
    </script>

    <style>
        @media (min-width: 992px) {
            #desktop_hide {
                display: none;
            }
        }
    </style>
</head>

<body onload="initialize_map(); initialize()">
    <!-- <div id="title">Show Position In Map</div>
    <div id="current">Initializing...</div> -->
    <!-- <div id="map_canvas" style="width:320px; height:350px"></div> -->