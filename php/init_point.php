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

                            $lastday = $data[0]['mrttime_date'];
                            $mrttime = date('G'); // 0-23
                            $mrtid = $data[0]['mrttime_id'];

                            if( $mrttime==2 || $mrttime==3 || $mrttime==4 ) {
                                $mrttime = 6;
                            }

                            // mrttime_id, mrttime, lastday
                            // $data2 = get_sql($con,
                            //         "(SELECT x.mrttime_id, x.volume, @i := @i + 1 as row_number" 
                            //         ." FROM (SELECT mrttime_id, (mrttime_in+mrttime_out) as 'volume'"
                            //         ." FROM mrttime "
                            //         ." WHERE mrttime_date = '" .$lastday. "' AND mrttime_time = '" .$mrttime. "'"
                            //         ." ) x, (SELECT @i :=0) temp ORDER BY 2 ASC "
                            //         ." ) as y",
                            //        " WHERE y.mrttime_id = '" .$mrtid. "'" ,
                            //        "y.mrttime_id, y.volume, y.row_number");

                            $data2 = get_sql($con,
                                    "(SELECT x.mrttime_id, x.volume, @i := @i + 1 as row_number FROM (  SELECT mrttime_id, (mrttime_in+mrttime_out) as 'volume'  FROM mrttime WHERE mrttime_date = '" .$lastday. "' AND mrttime_time = '" .$mrttime. "') x, (SELECT @i :=0) temp ORDER BY 2 ASC ) as y",
                                   " WHERE y.mrttime_id = '" .$mrtid. "'" ,
                                   "y.mrttime_id, y.volume, y.row_number");
                  
                            if( $data2 ) {


                                    $MAX = 108;
                                    $Q_3 = 81.25;
                                    $Q_2 = 54.5;
                                    $Q_1 = 27.75;
                                    $MIN = 0;

                                    $volume = $data2[0]['volume'];
                                    $mrtid = $data2[0]['mrttime_id'];
                                    $station_rowcnt = $data2[0]['row_number'];

                                    $color = '';
                                    $bkcolor = '';

                                    if( intval($station_rowcnt) >= $MAX ) {

                                        $color = 'red';
                                        $bkcolor = '#ffb6b6';
                                        
                                    } else if( intval($station_rowcnt) >= $Q_3 ) {

                                        $color = 'orange';
                                        $bkcolor = '#ff9b70';

                                    } else if( intval($station_rowcnt) >= $Q_2 ) {

                                        $color = 'yellow';
                                        $bkcolor = '#fffba2';

                                    } else if( intval($station_rowcnt) >= $Q_1 ) {

                                        $color = 'green';
                                        $bkcolor = '#9bffa6';

                                    } else {

                                        $color = 'blue';
                                        $bkcolor = '#a7cfff';

                                    }

                                    $callback['data'] = array( 'mrtid' => $mrtid,
                                                                'volume' => $volume,
                                                                'color' => $color,
                                                                'bkcolor' => $bkcolor);
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

// SELECT *
// FROM mrttime
// WHERE mrttime_date LIKE '%11-01' AND mrttime_id IN (
// SELECT mrtid_id FROM mrtid WHERE mrtid_name = '松山')

// SELECT DAYOFWEEK(mrttime_date) as 'weekday', mrttime_date
// FROM mrttime
// ORDER BY mrttime_date DESC LIMIT 1;

// 取得最新之日期是星期幾


// var weekday;

// switch ( dayofweek ) {


//     case '1':   // 日

//        // 日 (上)
//         subtractDay = (1+6);

//         break;
//     case '2':   // 一

//         // 日 一 (上)
//         subtractDay = (2+6);

//         break;
//     case '3':   // 二

//         // 日 一 二 (上)
//         subtractDay = (3+6);

//         break;
//     case '4':   // 三

//         // 日 一 二 三 (上)
//         subtractDay = (4+6);

//         break;
//     case '5':   // 四

//         // 日 一 二 三 四 (上)
//         subtractDay = (5+6);

//         break;
//     case '6':   // 五

//         // 日 一 二 三 四 五 (上)
//         subtractDay = (6+6);

//         break;
//     case '7':   // 六
//         // 日 一 二 三 四 五 六 (h3)
//         subtractDay = 0;
//         break;
// }

// SELECT * 
//   FROM calendar 
//  WHERE dt BETWEEN CURDATE()-INTERVAL 1 WEEK AND CURDATE();

    /** 所有站在這一週的資料 */
    /** This week */
    // SELECT (in + out) as 'total'
    // FROM mrttime
    // WHERE mrttime_date BETWEEN 'now' AND DATE_SUB(now, INTERVAL "subtractDay" DAY)
    //    AND mrttime_time = 'now_time'
    // ORDERY BY 1

    /* SELECT x.mrttime_id, x.volume, @i := @i + 1 as row_number 
                                    FROM (
                                    SELECT mrttime_id, (mrttime_in+mrttime_out) as 'volume'
                                    FROM mrttime
                                    WHERE mrttime_date = '2017-01-24' AND mrttime_time = '6'
                                    ) x, (SELECT @i :=0) temp ORDER BY 2 ASC*/

                                    /*
                                    SELECT y.mrttime_id, y.volume, y.row_number 
                                    FROM (
                                        SELECT x.mrttime_id, x.volume, @i := @i + 1 as row_number 
                                        FROM (
                                        SELECT mrttime_id, (mrttime_in+mrttime_out) as 'volume'
                                        FROM mrttime
                                        WHERE mrttime_date = '2017-01-24' AND mrttime_time = '6'
                                        ) x, (SELECT @i :=0) temp ORDER BY 2 ASC 
                                        ) as y
                                    WHERE y.mrttime_id = '102';
                                    */
?>