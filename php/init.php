<?php

   
    function getMRTpoint() {

        $callback = array();

        try{

            // MRT 點
            $no = 0;
            $dbname="MRT.csv";  //開啟
            $file = fopen($dbname,"r");
            while(!feof($file))
            {
                    $str =explode(',',fgets($file));
                    $no++;
                    if(isset($str[1])){

                        if($str[1]==$_REQUEST['id']){

                            // 搜尋景點資料
                            $mrtpoint = array("no"  => $no,
                                            "mrtstation" => $str[0],
                                            "name"  => $str[1],
                                            "lng"   => $str[3],
                                            "lat"   => $str[4],
                                            "bar"   => getMRTminute( $str[0] )
                                            );

                            $callback['data'] = $mrtpoint;
                            $callback['success'] = true;

                        }

                    }
            }

        } catch (Exception $e)

        {
                $callback['msg'] = $e;
                $callback['success'] = false;
        }

        return json_encode($callback);

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

    // date mart
    function getMRTminute( $name ) {

        $mrtname = $name;

        date_default_timezone_set("Asia/Taipei");

        $callback = array();

        try{

                    $DB_CON = DB_CON( DB_NAME );
                    if( !$DB_CON["success"] ){
                            return $DB_CON;
                    }

                    $con = $DB_CON["data"];

                    /*
                    SELECT *
                    FROM mrttime
                    WHERE mrttime_date LIKE '%11-01' AND mrttime_id IN (
                    SELECT mrtid_id FROM mrtid WHERE mrtid_name = '松山'
                    );
                    */

                    $today = date('m-d');   // 今天的日期
                    $time = date('H');      // 今天的時間
                            
                    // +-5
                    $min_time = ($time-5) < 0 ? 0 : ((int)$time)-5;
                    $max_time = ($time+5) > 23 ? 23 : ((int)$time)+5;


                    $data = get_sql($con,
                                    "mrttime",
                                   "WHERE mrttime_date LIKE '%16-" .$today. "' AND mrttime_time BETWEEN " .$min_time. " AND " .$max_time. " AND mrttime_id IN (SELECT mrtid_id FROM mrtid WHERE mrtid_name = '" .$mrtname. "')" ,
                                   "mrttime_id, mrttime_date, mrttime_time, mrttime_in, mrttime_out");
                                   
                    if( $data ) {

                            $callback['data'] = $data;
                            $callback['time'] = array('min_time'=> $min_time, 'max_time'=>$max_time, 'circle'=> getPointColor($data[0]['mrttime_id']));
                            $callback['success'] = true;
                    }
                    else {
                            $callback['data'] = array();
                            $callback['success'] = true;
                    }

                    mysqli_close($con);

                    return $callback;

            }
            catch (Exception $e)
            {
                    echo "false";
            }

    }

?>