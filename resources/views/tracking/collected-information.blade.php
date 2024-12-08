<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>IP and Location Details</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table thead {
            background-color: #ADD8E6;
            color: white;
            font-weight: bold;
        }

        .table th {
            padding: 12px;
            text-align: left;
        }

        .table td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        .table tbody tr:nth-child(odd) {
            background-color: #f9f9f9;
        }

        .table tbody tr:nth-child(even) {
            background-color: #ffffff;
        }

        #map {
            width: 100%;
            height: 400px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h1>Location and IP Information</h1>

    <h2>Address Information:</h2>
    <p><strong>Latitude:</strong> {{ $latitude }}</p>
    <p><strong>Longitude:</strong> {{ $longitude }}</p>
    <p><strong>IP Address:</strong> {{ $ip }}</p>


    <h2>Google Map:</h2>
    <div id="map"></div>

    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap" async defer></script>

    <script>
        let map, marker;

        function initMap() {
            const initialPosition = {
                lat: {{ $latitude }},
                lng: {{ $longitude }}
            };

            map = new google.maps.Map(document.getElementById("map"), {
                zoom: 15,
                center: initialPosition,
                mapTypeId: 'roadmap',
            });

            marker = new google.maps.Marker({
                position: initialPosition,
                map: map,
                title: "Your Location",
            });
        }

        function updateMap(latitude, longitude) {
            const userPosition = {
                lat: latitude,
                lng: longitude
            };

            map.setCenter(userPosition);
            map.setZoom(15);
            marker.setPosition(userPosition);
        }
    </script>
</body>
</html>
