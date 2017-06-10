<?php

	include 'global.php';


	$func = $_REQUEST["func"];

    switch ($func) {
        case "getScene":
            $echo = getScene();
            break;
    }

    echo json_encode($echo);

	function getScene() {

		$callback = array();

		try{


			$json = file_get_contents('../scene.json');
			// $obj = json_decode($json);
			// $list = $obj->result->results;

			//-------------------------------------
			// $curl_handle=curl_init();
			// curl_setopt($curl_handle, CURLOPT_URL,'http://data.taipei/opendata/datalist/apiAccess?scope=resourceAquire&rid=36847f3f-deff-4183-a5bb-800737591de5');
			// curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
			// curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
			// curl_setopt($curl_handle, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.2; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.96 Safari/537.36');
			// $json = curl_exec($curl_handle);
			// curl_close($curl_handle);
			//-------------------------------------

			// $json = file_get_contents('http://data.taipei/opendata/datalist/apiAccess?scope=resourceAquire&rid=36847f3f-deff-4183-a5bb-800737591de5');

			$obj = json_decode($json);
			$list = $obj->result->results;

			if( !empty($_REQUEST['id']) || isset($_REQUEST['id']) ) {

				$id = $_REQUEST['id'];

			} else {

				$id = null;

			}


			if( !is_null($id) ) {

				foreach ( $list as $value ) {

					if( $value->_id===$id ) {

						// $img = preg_split("/http/",$value->file);


							$item = array(
										 'id' => $value->_id,
										 'class'=> $value->CAT2,
										 'stitle'=> $value->stitle,
										 'address'=> $value->address,
										 'path'=> $value->info,
										 'station'=> $value->MRT,
										 'scene'=> $value->xbody,
										 'image'=> preg_split("/jpg|JPG/",$value->file)
										 );

					}

					//print_r($value->name);
					// echo '旅遊類別: '.$value->CAT2."<br>";
					// echo '景點名稱: '.$value->stitle."<br>";
					// echo '景點地址: '.$value->address."<br>";
					// echo '交通路線: '.$value->info."<br>";
					// echo '附近捷運站: '.$value->MRT."<br>";
					// echo '景點簡介: '.$value->xbody."<br>";
					//echo(preg_split('jpg',$value->file));
					// foreach ( preg_split("/jpg/",$value->file) as $phto ){

					// echo '<img src="'.$phto.'jpg'.'" alt="不好意思這張圖片掛了，請致電到台北觀光局抗議" title="'.$value->stitle.'的實地照片" width="150px" height="150px">';

				}

				if( isset($item) ) {

						$callback['success'] = true;
						$callback['data'] = $item;

				} else {

						$callback['success'] = false;
						$callback['msg'] = '查無此景點';

				}

			} else {

						$callback['success'] = false;
						$callback['msg'] = '沒輸入查詢資訊';

			}

			// <br><a href="http://maps.google.com.tw/maps?f=q&hl=zh-TW&geocode=...>latitude.','.$value->longitude.'" target="_blank" >Google 地圖</a> <br>';
			// echo 'longitude: '.$value->longitude."<br>";
			// echo 'latitude: '.$value->latitude."<br><hr>"; //address
			// //echo"<iframe width='100%' height='200' frameborder='0' scrolling='no' marginheight='0' marginwidth='0' src='"&z=16&output=embed&t='></iframe><hr>";
			/*echo $obj->sites;*/

		} catch (Exception $e)

	    {
		        $callback['msg'] = $e;
		        $callback['success'] = false;
	    }

	    return $callback;

	}


	// 檢查圖檔是否完整
	function checkRemoteFile($url)
	{
		    $ch = curl_init();
		    curl_setopt($ch, CURLOPT_URL,$url);
		    // don't download content
		    curl_setopt($ch, CURLOPT_NOBODY, 1);
		    curl_setopt($ch, CURLOPT_FAILONERROR, 1);
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		    if(curl_exec($ch)!==FALSE)
		    {
		    	curl_close($ch);
		        return true;
		    }
		    else
		    {
		    	curl_close($ch);
		        return false;
		    }
	}

?>