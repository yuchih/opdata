<?php

    include 'config.php';
	include 'global.php';


	$func = $_REQUEST["func"];

    switch ($func) {
        case "getWeekWeather":
            $echo = getWeekWeather();
            break;
    }


    echo json_encode($echo);


    function getWeekWeather() {


        $callback = array();

		try{

            $xml = simplexml_load_file("../F-C0032-003.xml") or die("Error: Cannot create object.");
            $list = json_encode($xml);
            $obj = json_decode($list);

            $tmp = array();

            // $date = array();
            // $weatherStatus = array();
            // $rainPercentage = array();
            // $temperatureAvg = array();

            for ( $i=0 ; $i<7 ; $i++ ) {

                $item = $obj->dataset->location[0]->weatherElement[0]->time[$i];

                $date = preg_split("/T/", $item->startTime)[0];

                if( strpos( $item->parameter->parameterName, '雲' ) !== false &&
                    strpos( $item->parameter->parameterName, '雨' ) !== false)
                {
                    // 下大雨
                    $weatherStatus = 'css/img/rain.png';

                }
                else if(strpos( $item->parameter->parameterName, '雲' ) !== false &&
                         strpos( $item->parameter->parameterName, '雨' ) == false )
                {
                    // 太陽公公、雲
                    $weatherStatus = 'css/img/sun_cloud.png';

                } else{

                    // 太陽公公
                    $weatherStatus = 'https://scontent-tpe1-1.xx.fbcdn.net/v/t34.0-12/18360656_1786402268040517_1539067106_n.png?oh=2b0fb5ea00666b5404f1b1355b599319&oe=59105F0A';
                }


                // 降雨機率
                $rainPercentage = preg_split("/T/", ($item->parameter->parameterValue))[0];

                // 平均氣溫
                $temperatureAvg = preg_split("/T/", ($obj->dataset->location[0]->weatherElement[1]->time[$i]->parameter->parameterName))[0];

                array_push($tmp, array("date" => $date,
                                        "weatherStatus" => $weatherStatus,
                                        "rainPercentage" => $rainPercentage,
                                        "temperatureAvg" => $temperatureAvg));

            };

            $callback['data'] = $tmp;
		    $callback['success'] = true;


        } catch (Exception $e)

	    {
		        $callback['msg'] = $e;
		        $callback['success'] = false;
	    }

	    return $callback;

    }





?>