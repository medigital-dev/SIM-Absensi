// var latitude = document.getElementById('latitude');
// var longitude = document.getElementById('longitude');
// var tampil      = document.getElementById('tampilkan');

// var x = document.getElementById("notif_go");

// if (navigator.geolocation) {
//     navigator.geolocation.getCurrentPosition(showPosition);
// } else { 
//     x.innerHTML = "Geolocation is not supported by this browser.";
// }

// function showPosition(position) {
//     latitude.value = position.coords.latitude;
//     longitude.value = position.coords.longitude;
//     tampil.innerHTML = "<a class='text-decoration-none' target='blank' href='https://www.google.com/maps/search/" + position.coords.latitude + "," + position.coords.longitude + "'>" + "<i class='fas fa-map-marked-alt fa-fw me-1'></i>" + position.coords.latitude + "," + position.coords.longitude + "</a>";
// }



// var apiGeolocationSuccess = function(position) {
//     alert("API geolocation success!\n\nlat = " + position.coords.latitude + "\nlng = " + position.coords.longitude);
// };

// var tryAPIGeolocation = function() {
//     jQuery.post( "https://www.googleapis.com/geolocation/v1/geolocate?key=AIzaSyDCa1LUe1vOczX1hO_iGYgyo8p_jYuGOPU", function(success) {
//         apiGeolocationSuccess({coords: {latitude: success.location.lat, longitude: success.location.lng}});
//   })
//   .fail(function(err) {
//     alert("API Geolocation error! \n\n"+err);
//   });
// };

// var browserGeolocationSuccess = function(position) {
//     alert("Browser geolocation success!\n\nlat = " + position.coords.latitude + "\nlng = " + position.coords.longitude);
// };

// var browserGeolocationFail = function(error) {
//   switch (error.code) {
//     case error.TIMEOUT:
//       alert("Browser geolocation error !\n\nTimeout.");
//       break;
//     case error.PERMISSION_DENIED:
//       if(error.message.indexOf("Only secure origins are allowed") == 0) {
//         tryAPIGeolocation();
//       }
//       break;
//     case error.POSITION_UNAVAILABLE:
//       alert("Browser geolocation error !\n\nPosition unavailable.");
//       break;
//   }
// };

// var tryGeolocation = function() {
//   if (navigator.geolocation) {
//     navigator.geolocation.getCurrentPosition(
//         browserGeolocationSuccess,
//       browserGeolocationFail,
//       {maximumAge: 50000, timeout: 20000, enableHighAccuracy: true});
//   }
// };

// tryGeolocation();