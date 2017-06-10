<?php

        $str = "http://opendata.epa.gov.tw/ws/Data/ATM00505/?format=xml";
        $xml = new SimpleXMLElement($str, null, true);
        $list = json_encode($xml);
        $obj = json_decode($list);
        print_r($obj->Data[0]->SiteId);
        foreach ( $obj->Data as $value ){
        printf($value->SiteName);
        if($value->ItemName == "風向")
        printf($value->ItemName); 
        echo "<br>";
        }



?>