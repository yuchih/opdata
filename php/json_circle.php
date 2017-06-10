<?php 


    // 圈圈的顏色
    function getPointColor( $mrtid ) {

    date_default_timezone_set("Asia/Taipei");
 
    $callback = array();

        try{

                    $DB_CON = DB_CON( DB_NAME );
                    if( !$DB_CON["success"] ){
                            return $DB_CON;
                    }

                    $con = $DB_CON["data"];

                    $weekOfDay = date('w'); // 0: SUNDAY

                    // 拿取到最新資料的一個禮拜
                    $data = get_sql($con,
                                   "mrttime",
                                   "WHERE mrttime_id = " .$mrtid. " AND DAYOFWEEK(mrttime_date) = '" .(intval($weekOfDay)+1). "' ORDER BY mrttime_date DESC LIMIT 1" ,
                                   "mrttime_id, DAYOFWEEK(mrttime_date) as 'weekday', mrttime_date");
              
                    /*
                        SELECT mrttime_id, DAYOFWEEK(mrttime_date) as 'weekday', mrttime_date
                        FROM mrttime
                        WHERE mrttime_id = '2' AND DAYOFWEEK(mrttime_date) = '3'
                        ORDER BY mrttime_date DESC LIMIT 1
                    */

                    if( $data ) {

                            $lastday = $data[0]['mrttime_date'];    // 日期
                            $mrttime = date('G');                   // 0-23
                            //$mrtid = $data[0]['mrttime_id'];      // 暫時不限制

                            // 休息時間處理
                            if( $mrttime==2 || $mrttime==3 || $mrttime==4 ) {
                                $mrttime = 6;
                            }

                            // SELECT mrtid_name, y.mrttime_id, y.volume, y.row_number 
                            //         FROM (
                            //             SELECT x.mrttime_id, x.volume, @i := @i + 1 as row_number 
                            //             FROM (
                            //             SELECT mrttime_id, (mrttime_in+mrttime_out) as 'volume'
                            //             FROM mrttime
                            //             WHERE mrttime_date = '2017-01-24' AND mrttime_time = '6'
                            //             ) x, (SELECT @i :=0) temp ORDER BY 2 ASC 
                            //             ) as y, mrtid
                            //             WHERE y.mrttime_id = mrtid_id
                            //             ORDER BY 4 ASC
                                    
                            $data2 = get_sql($con,
                                    "(  SELECT x.mrttime_id, x.volume, @i := @i + 1 as row_number"
                                   ." FROM ( SELECT mrttime_id, (mrttime_in+mrttime_out) as 'volume'"
                                   ." FROM mrttime WHERE mrttime_date = '" .$lastday. "' AND mrttime_time = '" .$mrttime. "'"
                                   ." ) x, (SELECT @i :=0) temp ORDER BY 2 ASC ) as y, mrtid",
                                   " WHERE y.mrttime_id = mrtid_id ORDER BY 4 ASC",
                                   "mrtid_name, y.mrttime_id, y.volume, y.row_number");
                  
                            if( $data2 ) {

                                    // 108 rows

                                    $MAX = 108;
                                    $Q_3 = 81.25;
                                    $Q_2 = 54.5;
                                    $Q_1 = 27.75;
                                    $MIN = 0;

                                    $temp = array();

                                    foreach($data2 as $key => $value) {

                                        $mrtid_name = $value['mrtid_name'];
                                        $mrttime_id = $value['mrttime_id'];
                                        $volume = $value['volume'];
                                        $station_rowcnt = $value['row_number'];

                                        $color = '';


                                        if( intval($station_rowcnt) >= $MAX ) {

                                            $color = '5';
                                        
                                        } else if( intval($station_rowcnt) >= $Q_3 ) {

                                            $color = '4';

                                        } else if( intval($station_rowcnt) >= $Q_2 ) {

                                            $color = '3';

                                        } else if( intval($station_rowcnt) >= $Q_1 ) {

                                            $color = '2';

                                        } else {

                                            $color = '1';

                                        }

                                        $temp[$mrtid_name] = array( 'mrtid' => $mrttime_id,
                                                                    'mrtname' => $mrtid_name,
                                                                    'volume' => $volume,
                                                                    'color' => $color );

                                        // array_push( $temp, array( 'mrtid' => $mrttime_id,
                                        //                             'mrtname' => $mrtid_name,
                                        //                             'volume' => $volume,
                                        //                             'color' => $color ));

                                    }

                                   
                                    $callback['data'] = $temp;
                                    $callback['success'] = true;

                                    
                            } else {
                                    $callback['msg'] = 'data2 error';
                                    $callback['success'] = false;
                            }

                    }
                    else {
                            $callback['msg'] = 'data error';
                            $callback['success'] = false;
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