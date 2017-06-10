<html lang="zh">

<head>

  <meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
 	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="author" content="op team">
  <meta name="description" content="works">

  <title>OP</title>

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
  <?php //include 'html/carousel.html'; ?>
  <?php include 'html/modal.html'; ?>
  

  <div class="container-fluid">

          <div class="row">
             <div id="mapid" style="width: 100%; height: 70%;"></div>

              <div class="clearfix"></div>

              <div class="col-md-12 barContainer">
                  <div id="barchart" style="height: 26%";></div>
              </div>
          </div>

  </div>


  <!-- bootstrap -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
  <!-- bootstrap -->

  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script><!--barchart-->
  <script type="text/javascript" src="barchart.js"></script><!--barchart-->

	<script src="js/global.js"></script>

  <script>

  $(document).ready(function(){

    




    var LeafIcon = L.Icon.extend({
          options: {iconSize:[35, 35]}
        });
  
    var lat = getParameterByName('lat');
    var lng = getParameterByName('lng');

        var mymap = L.map('mapid', { center:[lat, lng], zoom: 15 });
        // L.map('mapid').panTo(new L.LatLng(25.0479, 121.5171));
        L.marker([lat, lng]).addTo(mymap).bindPopup("目前空氣盒子位置").openPopup();
        // var mymap = L.map('mapid').locate({setView: true, maxZoom: 18});

        L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
          maxZoom: 18,
          id: 'mapbox.streets'
        }).addTo(mymap);

        L.circle({lat,lng}, 1000).addTo(mymap);


    

          // 路線規劃
          var current_a = 0;
          var routing;

          function onClick(e) {
              if (current_a == 0){
                routing = L.Routing.control({
                    waypoints: [
                    L.latLng( lat, lng ),
                    L.latLng( e.latlng.lat, e.latlng.lng)
                  ]
                }).addTo(mymap);
                  current_a=1;
              }
          }

//------
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
              marker.bindPopup('<span id="smallbox">' +name+ '</span><br><a href="map2.php?lat=' +lat+ '&lng=' +lng+ '">前往查看</a>').on('click', onClick);
              
          }

           
        });

      } else {

            console.log(data.msg);

      }
   };

  var error_back = function(data) { console.log(data); };
  $.Ajax("POST", "php/json_factory.php?func=getBox", data, "", success_back, error_back);

        //---------------------------------------------------------------------------------
        var data = {
          lat: getParameterByName('lat'),
          lng: getParameterByName('lng')
        };


          var success_back = function(data) {

              data = JSON.parse(data);
              console.log(data);

              if (data.success) {

                var data = data.data;

                var LeafIcon_3 = L.Icon.extend({
                  options: {iconSize:[35, 35]}
                });
                
                var blueIcon = new LeafIcon_3({iconUrl: 'css/img/factory.png'});
                
                $.each( data, function(index, value){

                  if (lat!='NA' || lng!='NA') {

                      var id = value['cems_cid'];
                      var name = value['cems_name'];
                      var address = value['cems_address'];
                      var lat = value['cems_lat'];
                      var lng = value['cems_lng'];
                      var color = blueIcon;

                      var marker =  L.marker([ lat, lng ],{icon: color}).addTo(mymap);
                    marker.bindPopup('<span id="smallbox">' +name+ '</span><span>' +address+ '</span><br><a href="map2.php?id="' +id+ '">前往查看</a>').on('click', onClick);
                      
                  }

                  
                });

              } else {

                    console.log(data.msg);

              }
          };

          var error_back = function(data) { console.log(data); };
          $.Ajax("POST", "php/json_factory.php?func=getBox2", data, "", success_back, error_back);
          //---------------------------------------------------------------------------------

           //---------------------------------------------------------------------------------
        var data = {
          address: getParameterByName('address')
        };


          var success_back = function(data) {

              data = JSON.parse(data);
              console.log(data);

              if (data.success) {

                var data = data.data;

                console.log(data);
                $(".barContainer").append('<span>風向:' +data+ '</span>');
                  

              } else {

                    console.log(data.msg);

              }
          };

          var error_back = function(data) { console.log(data); };
          $.Ajax("POST", "php/json_factory.php?func=getWind", data, "", success_back, error_back);
          //---------------------------------------------------------------------------------

          // 地圖點擊
          mymap.on('click', function(e) {

            if (current_a==1){
              routing.spliceWaypoints(0, 2);
              var elements = document.getElementsByClassName("leaflet-routing-container");
                  while(elements.length > 0){
                      elements[0].parentNode.removeChild(elements[0]);
                  }

              //this.removeControl(routing);
              // map.removeControl(routing);
              //map.update();

              current_a=0;
            }

          });

 
  });



</script>



</body>
</html>