<?php


	$func = $_REQUEST["func"];

    switch ($func) {
        // "scenes" => getScenePoint($str[4], $str[3])
        case "getScenePoint":
            $echo = getScenePoint();
            break;
    }

    echo json_encode($echo);


    // lat, long 景點資料
    function getScenePoint() {

        $callback = array();

        try{

                $lat = $_REQUEST['lat'];
                $long = $_REQUEST['long'];

                $no=0;

                $json = file_get_contents('../scene.json');
                // $json = file_get_contents('data.json');
                $obj = json_decode($json);
                $list = $obj->result->results;

                $scenes = array();

                foreach ( $list  as $value ){
                    //echo 'longitude: '.$value->longitude."<br>";
                    //echo 'latitude: '.$value->latitude."<br><hr>";
                    $aa = getDistance( $lat, $long, $value->latitude, $value->longitude);
                    if ($aa<500){

                        $no++;
                        array_push($scenes, array("no"=> $no,
                                                "id" => $value->_id,
                                                "lat" =>$value->latitude,
                                                "lng" =>$value->longitude,
                                                "title" => $value->stitle,
                                                "discussion" => rand(1,100),
                                                "mrt" => $value->MRT)
                        );
										
                    }
                }

                $callback['data'] = $scenes;
                $callback['success'] = true;


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

?>