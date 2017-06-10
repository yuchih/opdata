<?php
$json = file_get_contents('http://data.taipei/opendata/datalist/apiAccess...');
$obj = json_decode($json);
$list =$obj->result->results;
foreach ( $list as $value ){
//print_r($value->name);
echo '旅遊類別: '.$value->CAT2."<br>";
echo '景點名稱: '.$value->stitle."<br>";
echo '景點地址: '.$value->address."<br>";
echo '交通路線: '.$value->info."<br>";
echo '附近捷運站: '.$value->MRT."<br>";
echo '景點簡介: '.$value->xbody."<br>";
//echo(preg_split('jpg',$value->file));
foreach ( preg_split("/jpg/",$value->file) as $phto ){
echo '<img src="'.$phto.'jpg'.'" alt="不好意思這張圖片掛了，請致電到台北觀光局抗議" title="'.$value->stitle.'的實地照片" width="150px" height="150px">';
}
// echo '<br><a href="http://maps.google.com.tw/maps?f=q&hl=zh-TW&geocode=...>latitude.','.$value->longitude.'" target="_blank" >Google 地圖</a> <br>';
// echo 'longitude: '.$value->longitude."<br>";
// echo 'latitude: '.$value->latitude."<br><hr>"; //address
// //echo"<iframe width='100%' height='200' frameborder='0' scrolling='no' marginheight='0' marginwidth='0' src='"&z=16&output=embed&t='></iframe><hr>';
}
//echo $obj->sites;
?>