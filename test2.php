	<?php 


    

    // MRT 點
		// $no=0;
		// $dbname="MRT.csv";  //開啟
 		// $file = fopen($dbname,"r");
		// while(!feof($file))
 		//  { 	
 		//   $str =explode(',',fgets($file));
  	// 	  $no++;
    //     if(isset($str[1])){
  	// 	  if($str[1]==$_GET['id']){
    //       echo 'var marker'.$no.' = L.marker(['.$str[4].','.$str[3].'],{icon:placeholder}).addTo(mymap);';  
    //       echo 'marker'.$no.'.bindPopup("<strong>'.$str[1].'</strong>").openPopup().on(\'click\', onClick);'; 
    //       echo'  var long = '.$str[3].';';  
    //       echo'  var lat = '.$str[4].';';  
    //       $long=$str[3];
    //       $lat=$str[4];
    //       }      
    //     } 
 		//  }


      /*
      
      var marker352 = L.marker([25.05152
,121.552549],{icon:placeholder}).addTo(mymap);marker352.bindPopup("<strong>台北小巨蛋站出口3</strong>").openPopup().on('click', onClick);  var long = 121.552549;  var lat = 25.05152
;

      */ 


	?>

  // 圈圈
//   L.control.scale().addTo(mymap);
//   mymap.setView([lat, long], 16);
//    var circle = L.circle([lat,long], {
//     color: 'green',
//     fillColor: '#33FFDD',
//     fillOpacity: 0.5,
//     radius: 500
// }).addTo(mymap);


	  <?php 

    // 景點資料
 	//   $json = file_get_contents('http://data.taipei/opendata/datalist/apiAccess?scope=resourceAquire&rid=36847f3f-deff-4183-a5bb-800737591de5');
  //  // $json = file_get_contents('data.json');
	// 	$obj = json_decode($json);
	// 	$list =$obj->result->results;
		
	// 	foreach ( $list  as $value ){
	// //echo 'longitude: '.$value->longitude."<br>";
	// //echo 'latitude: '.$value->latitude."<br><hr>"; 
	// $aa = getDistance($lat,$long,$value->latitude,$value->longitude);
	// if ($aa<500){
	//   echo 'var marker'.$no.' = L.marker(['.$value->latitude.','.$value->longitude.'],{icon:placeholder}).addTo(mymap);';  
  //     echo 'marker'.$no.'.bindPopup("<strong>'.$value->stitle.'</strong><br><a href=\'# \'>目前討論此的文章:'.rand(1,100).'</a><br>附近捷運站:'.$value->MRT.'").openPopup().on(\'click\', onClick);';
  //     $no++;
	// 	}
	// } 
      ?>


      // 
    // mymap.on('click', function(e) {    
   
    //   if (a==1){
    //   routing.spliceWaypoints(0, 2);
    //   var elements = document.getElementsByClassName("leaflet-routing-container");
    //       while(elements.length > 0){
    //           elements[0].parentNode.removeChild(elements[0]);
    //       }
        
    //   //this.removeControl(routing);
    //   // map.removeControl(routing);
    //   //map.update();
    //   a=0;
    //   }
    
    // });

    <?php 
//  echo "   var a = 0;
//    var routing;
// function onClick(e) {
//     if (a == 0){
//  routing = L.Routing.control({
//     waypoints: [
//     L.latLng(".$lat.','.$long."),
//     L.latLng(e.latlng.lat,e.latlng.lng)
//   ]
// }).addTo(mymap);
//   a=1;
// }

// }";

    ?>