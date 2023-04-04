//              menentukan koordinat titik tengah peta
var myLatlng = new google.maps.LatLng(-6.176587,106.827115);
//              pengaturan zoom dan titik tengah peta
              var myOptions = {
                  zoom: 13,
                  center: myLatlng
              };
//              menampilkan output pada element
              var map = new google.maps.Map(document.getElementById("map"), myOptions);
//              menambahkan marker
              var marker = new google.maps.Marker({
                   position: myLatlng,
                   map: map,
                   title:"Monas"
              });