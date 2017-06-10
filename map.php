<html lang="zh">

<head>

  <meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
 	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="author" content="op team">
  <meta name="description" content="Homepage">

	<title>OP Station</title>

  <!-- bootstrap -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
	<link rel="stylesheet" href="css/one-col-portfolio.css" />
  <!-- bootstrap -->

	<link rel="shortcut icon" type="image/x-icon" href="docs/images/favicon.ico" />

  <!-- leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.0.3/dist/leaflet.css" integrity="sha512-07I2e+7D8p6he1SIM+1twR5TIrhUQn9+I6yjqD53JQjFiMf8EtC93ty0/5vJTZGF8aAocvHYNEDJajGdNx1IsQ==" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.0.3/dist/leaflet.js" integrity="sha512-A7vV8IFfih/D732iSSKi20u/ooOfj/AGehOKq0f4vLT1Zr2Y+RX7C+w8A1gaSasGtRUZpF/NZgzSAu4/Gc41Lg==" crossorigin=""></script>
    <link rel="stylesheet" href=".\sourse\leaflet-routing-machine.css" />
    <script src=".\sourse\leaflet-routing-machine.js"></script>
    <!-- leaflet -->

</head>

<body>

      <?php include 'html/loading.html'; ?>

      <div class="container-fluid">

              <div class="row">
                <div id="mapid" style="width: 100%; height: 70%;"></div><!-- map -->

                  <div class="clearfix"></div>

                  <div class="col-md-12 barContainer">
                      <table id="table" class="table table-bordered table-sm"></table><!-- table -->
                  </div>

              </div>

      </div>


  <!-- bootstrap -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
  <!-- bootstrap -->

	<script src="js/global.js"></script>

  <script>

  var data = {};
  var success_back = function(data) {

      data = JSON.parse(data);
      console.log(data);

      if (data.success) {

        var data = data.data;

        var LeafIcon_2 = L.Icon.extend({
          options: {iconSize:[21, 34]}
        });
        
        var ten = new LeafIcon_2({iconUrl: 'https://chart.googleapis.com/chart?chst=d_map_pin_letter&chld=空|ce30ff|000000'}),
            nine = new LeafIcon_2({iconUrl: 'https://chart.googleapis.com/chart?chst=d_map_pin_letter&chld=空|900|000000'}),
            eight = new LeafIcon_2({iconUrl: 'https://chart.googleapis.com/chart?chst=d_map_pin_letter&chld=空|ff0000|000000'}),
            seven = new LeafIcon_2({iconUrl: 'https://chart.googleapis.com/chart?chst=d_map_pin_letter&chld=空|ff6464|000000'}),
            six = new LeafIcon_2({iconUrl: 'https://chart.googleapis.com/chart?chst=d_map_pin_letter&chld=空|ff9a00|000000'}),
            five = new LeafIcon_2({iconUrl: 'https://chart.googleapis.com/chart?chst=d_map_pin_letter&chld=空|ffcf00|000000'}),
            four = new LeafIcon_2({iconUrl: 'https://chart.googleapis.com/chart?chst=d_map_pin_letter&chld=空|ff0|000000'}),
            three = new LeafIcon_2({iconUrl: 'https://chart.googleapis.com/chart?chst=d_map_pin_letter&chld=空|31cf00|000000'}),
            two = new LeafIcon_2({iconUrl: 'https://chart.googleapis.com/chart?chst=d_map_pin_letter&chld=空|31ff00|000000'}),
            one = new LeafIcon_2({iconUrl: 'https://chart.googleapis.com/chart?chst=d_map_pin_letter&chld=空|9cff9c|000000'});
        
        $.each( data, function(index, value){

          if (lat!='NA' || lng!='NA') {

              var device_id = value['device_id']
              var name = value['address'];
              var time = value['time'];
              var lat = value['lat'];
              var lng = value['lng'];
              var pm25 = parseInt(value['s_t0']);
              var color;

              if(pm25<=11)  {

                color = nine;

              } else if(pm25<=23) {

                color = eight;

              } else if (pm25<=35) {

                color = seven;

              } else if (pm25<=41) {

                color = six;

              } else if (pm25<=47) {

                color = five;

              } else if  (pm25<=53){

                color = four;

              } else if  (pm25<=58){

                color = three;

              } else if (pm25<=64)  {

                color = two;

              } else if (pm25<=70){

                color = one;

              } else {

                color = ten;

              }

              var marker =  L.marker([ lat, lng ],{icon: color}).addTo(mymap);
              marker.bindPopup('<span id="smallbox">' +name+ '</span><br><a href="map2.php?address=' +name+ '&lat=' +lat+ '&lng=' +lng+ '">前往查看</a>').on('click', onClick);
              
          }

           
        });

      } else {

            console.log(data.msg);

      }
   };

  var error_back = function(data) { console.log(data); };
  $.Ajax("POST", "php/json_factory.php?func=getBox", data, "", success_back, error_back);


  </script>

<script>
 <?php function getDistance($lat1, $lng1, $lat2, $lng2)
{
     $earthRadius = 6367000;
     $lat1 = ($lat1 * pi() ) / 180;
     $lng1 = ($lng1 * pi() ) / 180;
     $lat2 = ($lat2 * pi() ) / 180;
     $lng2 = ($lng2 * pi() ) / 180;
     $calcLongitude = $lng2 - $lng1;
     $calcLatitude = $lat2 - $lat1;
     $stepOne = pow(sin($calcLatitude / 2), 2) + cos($lat1) * cos($lat2) * pow(sin($calcLongitude / 2), 2);  $stepTwo = 2 * asin(min(1, sqrt($stepOne)));
     $calculatedDistance = $earthRadius * $stepTwo;
     return $calculatedDistance;
} ?>

        var LeafIcon = L.Icon.extend({
          options: {iconSize:[35, 35]}
        });

        var redIcon = new LeafIcon({iconUrl: 'https://chart.googleapis.com/chart?chst=d_map_pin_letter&chld=%E7%A9%BA|45aed9|000000'}),
            blueIcon = new LeafIcon({iconUrl: 'css/img/factory.png'});
            
    //   // legend
    // var legend = L.control({position: 'bottomright'});

    // legend.onAdd = function (map) {

    //     var div = L.DomUtil.create('div', 'info legend'),
    //         grades = ['bar'];

    //     div.innerHTML +=
    //             '<i style="background:yellow;"></i> ' +
    //              (" <img src='css/img/"+ grades[0] +".png' height='100' width='20'>") +'<br>';
        
    //     return div;
    // };

    // legend.addTo(mymap);



        var mymap = L.map('mapid', { center:[22.760995, 120.310350], zoom: 13 });
        // L.map('mapid').panTo(new L.LatLng(25.0479, 121.5171));
        L.marker([22.760995, 120.310350]).addTo(mymap).bindPopup("您的目前位置").openPopup();
        // var mymap = L.map('mapid').locate({setView: true, maxZoom: 18});

        L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
          maxZoom: 18,
          id: 'mapbox.streets'
        }).addTo(mymap);

        function onLocationFound(e) {
          var radius = e.accuracy / 2;
          L.marker(e.latlng).addTo(mymap)
              .bindPopup("您的目前位置").openPopup();
          L.circle(e.latlng, radius).addTo(mymap);
        }

        function onLocationError(e) {
            alert(e.message);
        }

        // L.circle([25.0479, 121.517], 250).addTo(mymap);
        
        mymap.on('locationerror', onLocationError);
        mymap.on('locationfound', onLocationFound);

        
        mymap.on('click', function(e) {

          if (a == 1) {

              routing.spliceWaypoints(0, 2);
              var elements = document.getElementsByClassName("leaflet-routing-container"); //leaflet-interactive
              var elemen = document.getElementsByClassName("leaflet-interactive"); //leaflet-interactive
              while (elements.length > 0) {

                  elements[0].parentNode.removeChild(elements[0]);
                  elemen[0].parentNode.removeChild(elemen[0]);
              }

              //this.removeControl(routing);
              // map.removeControl(routing);
              //map.update();
              a = 0;
          }
      });


    <?php
    
    /*  include 'php/config.php';
      include 'php/global.php';


      $dbname="cems.csv";  //開啟
      $file = fopen($dbname,"r");
      while(!feof($file))
      {
          $str = fgetcsv($file);

          if(isset($str[3])){
              
              // $mrtname = ($no===1) ? '頂埔' : $str[0];
              $color = '';
              $no = '1';

               $color = 'blueIcon';
              
              echo 'var marker'.$no.' = L.marker(['.$str[3].','.$str[4].'],{icon:'.$color.'}).addTo(mymap);';
              echo 'marker'.$no.'.bindPopup("<span id=\'smallbox\'>'.$str[1].'</span><br><a href=\'map2.php?id='.$str[1].' \'>前往查看</a>").on(\'click\', onClick);';
              
            }
      }
*/
echo "   var a = 0;
   var routing;
function onClick(e) {

      if (a == 0){
      
      var circle = L.circle([e.latlng.lat,e.latlng.lng], {
        color: 'red',
        fillColor: '#ffb6b6',
        fillOpacity: 0.5,
        radius: 1000
      }).addTo(mymap).bindPopup(\"500公尺內距離\");

  routing = L.Routing.control({
      waypoints: [
      L.latLng('22.760995, 120.310350'),
      L.latLng(e.latlng.lat,e.latlng.lng)
    ]
  }).addTo(mymap);

    a=1;
  }
}
";
?>


</script>


</body>
</html>