<?php

    include 'config.php';
    include 'global.php';


	$func = $_REQUEST["func"];

    switch ($func) {
        
        case "getBox":
            $echo = getBox();
            break;
        case "getBox2":
            $echo = getBox2();
            break;
         case "getWind":
            $echo = getWind();
            break;
    }

    echo json_encode($echo);


    function getBox() {

        $callback = array();

        try{


                $DB_CON = DB_CON( DB_NAME );
                    if( !$DB_CON["success"] ){
                            return $DB_CON;
                    }

                $con = $DB_CON["data"];

                $data = get_sql($con,
                                "weather_hour as wh, weather_compare as wc",
                                "WHERE wh.device_id = wc.device_id" ,
                                "wh.device_id, wh.time, wh.s_0, wh.s_1, wh.s_2, wh.s_3, wh.s_d0, wh.s_t0, wh.s_h0, wh.s_d1, wh.s_d2, wh.co2, wh.hcho, wh.tvoc, wh.co, wc.address, wc.lat, wc.lng");

                if( $data ) {

                         $temp = array();

                         foreach($data as $key => $value) {

                            array_push( $temp, $value );

                         }
                    
                        $callback['data'] = $temp;
                        $callback['success'] = true;


                } else {

                        $callback['msg'] = 'data error';
                        $callback['success'] = false;
                    
                } 

                mysqli_close($con);
                return $callback;

        } catch (Exception $e)

        {
                $callback['msg'] = $e;
                $callback['success'] = false;
        }

        return $callback;


    }


    // 計算距離
    function getDistance($lat1, $lng1, $lat2, $lng2) {
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
    }

     function getBox2() {

        $callback = array();

        try{

                $lat = $_REQUEST['lat'];
                $lng = $_REQUEST['lng'];

                $DB_CON = DB_CON( DB_NAME );
                    if( !$DB_CON["success"] ){
                            return $DB_CON;
                    }

                $con = $DB_CON["data"];

                $data = get_sql($con,
                                "cems",
                                "" ,
                                "cems_cid, cems_name, cems_address, cems_lat, cems_lng");

                if( $data ) {

                         $temp = array();

                         foreach($data as $key => $value) {

                            $aa = getDistance($lat, $lng,  $value['cems_lat'], $value['cems_lng']);
                            if($aa<1000) {
                                array_push( $temp, $value );
                            }
                           

                         }
                    
                        $callback['data'] = $temp;
                        $callback['success'] = true;


                } else {

                        $callback['msg'] = 'data error';
                        $callback['success'] = false;
                    
                } 

                mysqli_close($con);
                return $callback;

        } catch (Exception $e)

        {
                $callback['msg'] = $e;
                $callback['success'] = false;
        }

        return $callback;


    }


    function getWind() {

        $callback = array();

        try{

                $address = $_REQUEST['address'];

                  $str = "http://opendata.epa.gov.tw/ws/Data/ATM00505/?format=xml";
                    $xml = new SimpleXMLElement($str, null, true);
                    $list = json_encode($xml);
                    $obj = json_decode($list);

                if($obj) {  

                   
                    foreach ( $obj->Data as $value ){

                        $w = $value->ItemName;
                        
                        if(strpos($w, "風向") !== false) {

                            $name = $value->SiteName;

                            if(strpos($address, $name) !== false) {

                                $wind = $value->Concentration;

                            } else {

                                $wind = 'NA';

                            }

                        }
                       
                     
                        // printf($value->SiteName);
                        // if($value->ItemName == "風向")
                        // printf($value->ItemName); 
                        // echo "<br>";
                    }


                        $callback['data'] = $wind;
                        $callback['success'] = true;

                } else {

                        $callback['msg'] = 'data error';
                        $callback['success'] = false;
                    
                } 

                return $callback;

        } catch (Exception $e)

        {
                $callback['msg'] = $e;
                $callback['success'] = false;
        }

        return $callback;


    }

?>