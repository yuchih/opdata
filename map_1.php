<html>
<head>
	
	<title>Quick Start - Leaflet</title>

	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<link rel="shortcut icon" type="image/x-icon" href="docs/images/favicon.ico" />

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.0.3/dist/leaflet.css" integrity="sha512-07I2e+7D8p6he1SIM+1twR5TIrhUQn9+I6yjqD53JQjFiMf8EtC93ty0/5vJTZGF8aAocvHYNEDJajGdNx1IsQ==" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.0.3/dist/leaflet.js" integrity="sha512-A7vV8IFfih/D732iSSKi20u/ooOfj/AGehOKq0f4vLT1Zr2Y+RX7C+w8A1gaSasGtRUZpF/NZgzSAu4/Gc41Lg==" crossorigin=""></script>
 <link rel="stylesheet" href=".\sourse\leaflet-routing-machine.css" />

<script src=".\sourse\leaflet-routing-machine.js"></script>


</head>
<style>
table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
}
</style>
<body>
<div id="mapid" style="width: 100%; height: 80%;"></div>


<?php

$xml=simplexml_load_file("F-C0032-003.xml") or die("Error: Cannot create object");
$list =  json_encode($xml);
//echo($list);
$obj = json_decode($list);
//print_r($s[0]);

echo("<table style=\"width: 100%;\"><tr><td>日期</td>");
for ( $i=0 ; $i<7 ; $i++ ) {
echo("<td>".preg_split("/T/", $obj->dataset->location[0]->weatherElement[0]->time[$i]->startTime)[0]."</td>" );
};

  echo("</tr><tr><td>天氣概況</td>");
  for ( $i=0 ; $i<7 ; $i++) {
  	if(strpos( $obj->dataset->location[0]->weatherElement[0]->time[$i]->parameter->parameterName , '雲' ) !== false && strpos( $obj->dataset->location[0]->weatherElement[0]->time[$i]->parameter->parameterName , '雨' ) !== false){
echo('<td>'.'<img src="https://scontent-tpe1-1.xx.fbcdn.net/v/t34.0-12/18361175_1786408234706587_2020554909_n.png?oh=2032f8b68dfedd97e5e7072459a8256a&oe=591147A8" alt="替代文字一" title="範例圖片一">'.'</td>');
}
else if(strpos( $obj->dataset->location[0]->weatherElement[0]->time[$i]->parameter->parameterName , '雲' ) !== false && strpos( $obj->dataset->location[0]->weatherElement[0]->time[$i]->parameter->parameterName , '雨' ) ==false ){
echo('<td>'.'<img src="https://scontent-tpe1-1.xx.fbcdn.net/v/t34.0-12/18361364_1786397168041027_2114784016_n.png?oh=b8d0a501598443aee9db779d07dd6c96&oe=59106AAE" alt="替代文字一" title="範例圖片一">'.'</td>');
}
else{
	echo('<td>'.'<img src="https://scontent-tpe1-1.xx.fbcdn.net/v/t34.0-12/18360656_1786402268040517_1539067106_n.png?oh=2b0fb5ea00666b5404f1b1355b599319&oe=59105F0A" alt="替代文字一" title="範例圖片一">'.'</td>');
}
}; 
echo("</tr> <tr><td>降雨機率</td>");
  for ( $i=0 ; $i<7 ; $i++ ) {
echo("<td>".preg_split("/T/", ($obj->dataset->location[0]->weatherElement[0]->time[$i]->parameter->parameterValue))[0]."</td>") ;
};
echo("</tr> <tr><td>平均氣溫(℃)</td>");
  for ( $i=0 ; $i<7 ; $i++ ) {
echo("<td>".preg_split("/T/", ($obj->dataset->location[0]->weatherElement[1]->time[$i]->parameter->parameterName))[0]."</td>") ;
};
    
  echo("
  </tr>
</table>");


?>
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
var placeholder = L.icon({
        iconUrl: 'placeholder.png',
        iconSize: [38, 38], // size of the icon
        });
        var mymap = L.map('mapid').setView([25.015861, 121.533909], 18);

	L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
		maxZoom: 18,
		attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, ' +
			'<a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
			'Imagery © <a href="http://mapbox.com">Mapbox</a>',
		id: 'mapbox.streets'
	}).addTo(mymap);
	<?php 
		$no=0;
		$dbname="MRT.csv";  //開啟
 		$file = fopen($dbname,"r");
		while(!feof($file))
 		 { 	
 		  $str =explode(',',fgets($file));
  		  $no++;
  		  if(isset($str[3])){
          echo 'var marker'.$no.' = L.marker(['.$str[4].','.$str[3].'],{icon:placeholder}).addTo(mymap);';  
          echo 'marker'.$no.'.bindPopup("<strong>'.$str[1].'</strong><br><a href=\'map2.php?id='.$str[1].' \'>Search</a>").openPopup().on(\'click\', onClick);';   
          }       
 		 } 




	?>
	  <?php 
 	  /*	$json = file_get_contents('http://data.taipei/opendata/datalist/apiAccess?scope=resourceAquire&rid=36847f3f-deff-4183-a5bb-800737591de5');
		$obj = json_decode($json);
		$list =$obj->result->results;
		
		foreach ( $list  as $value ){
	//echo 'longitude: '.$value->longitude."<br>";
	//echo 'latitude: '.$value->latitude."<br><hr>"; 
	$aa = getDistance('25.015861','121.533909',$value->latitude,$value->longitude);
	if ($aa<500){
	  echo 'var marker'.$no.' = L.marker(['.$value->latitude.','.$value->longitude.'],{icon:placeholder}).addTo(mymap);';  
      echo 'marker'.$no.'.bindPopup("<strong>'.$value->stitle.'<br>附近捷運站:'.$value->MRT.'").openPopup().on(\'click\', onClick);';
      $no++;
		}
	} */
      ?>
     
        mymap.on('click', function(e) {    
   
if (a==1){

routing.spliceWaypoints(0, 2);
 var elements = document.getElementsByClassName("leaflet-routing-container");//leaflet-interactive
 var elemen = document.getElementsByClassName("leaflet-interactive");//leaflet-interactive
    while(elements.length > 0){

        elements[0].parentNode.removeChild(elements[0]);
         elemen[0].parentNode.removeChild(elemen[0]);
    }

   
//this.removeControl(routing);
// map.removeControl(routing);
//map.update();
a=0;
}
});
    <?php 
echo "   var a = 0;
   var routing;
function onClick(e) {
    if (a == 0){
    	 var circle = L.circle([e.latlng.lat,e.latlng.lng], {
    color: 'green',
    fillColor: '#33FFDD',
    fillOpacity: 0.5,
    radius: 500
}).addTo(mymap).bindPopup(\"五百公尺內距離\");

 routing = L.Routing.control({
    waypoints: [
    L.latLng(".'25.015861'.','.'121.533909'."),
    L.latLng(e.latlng.lat,e.latlng.lng)
  ]
}).addTo(mymap);
  a=1;
}

}";

    ?>



</script>



</body>
</html>