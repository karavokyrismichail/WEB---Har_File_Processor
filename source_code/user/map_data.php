<?php
    include('../server.php');
    ini_set('max_execution_time', 300);

        
    $user = $_SESSION['email'];
    $loc = array();

    $db = mysqli_connect('localhost', 'root', '', 'har_file_processor') or die($db);

    $sql = "SELECT COUNT(entries.entry_id), entries.serverIPAddress, entries.langitude, entries.longitude, entries.entry_id
    FROM ((entries INNER JOIN har_files ON entries.id_har = har_files.har_file_id)
    INNER JOIN users ON har_files.user_email = '$user') WHERE entries.map_check = 0 GROUP BY entries.serverIPAddress;";

    $stmt = mysqli_query($db, $sql);
    $numRows = mysqli_num_rows($stmt);
    if($numRows = 0){
        $sql_stored = "SELECT *
        FROM `har_file_processor`.`map_data` WHERE user = '$user';";
        $stored = mysqli_query($db,$sql_stored);
        $dataS = mysqli_fetch_all($stored);
        foreach ($dataS as $rows) 
        {                                
            $loc[] = array('lat' => $rows[0], 'lng' => $rows[1], 'count' => intval($rows[2]));
        }

        echo json_encode($loc, JSON_NUMERIC_CHECK);
    }else{//new data to stored
        //already stored data
        $sql_stored = "SELECT *
        FROM `har_file_processor`.`map_data` WHERE user = '$user';";
        $stored = mysqli_query($db,$sql_stored);
        $dataS = mysqli_fetch_all($stored);
        foreach ($dataS as $rows) 
        {                                
            $loc[] = array('lat' => $rows[0], 'lng' => $rows[1], 'count' => intval($rows[2]));
        }
        //new data 
        $data = mysqli_fetch_all($stmt);
        foreach ($data as $row) 
        { 
            $ip = $row[1];
            //im checking every entry that i use
            $sql_alter = "SELECT entries.entry_id
            FROM ((entries INNER JOIN har_files ON entries.id_har = har_files.har_file_id)
            INNER JOIN users ON har_files.user_email = '$user') ;";
            $stm = mysqli_query($db,$sql_alter);
            $d = mysqli_fetch_all($stm);
            foreach ($d as $entry) 
            {                                
                $sql_new = "UPDATE entries 
                        SET map_check = 1 
                        WHERE entry_id = '$entry[0]';";
                        mysqli_query($db,$sql_new);
            }
            $result = "";
            if($ip != ""){
                $ch =curl_init();
                curl_setopt($ch, CURLOPT_URL, "http://ip-api.com/json/{$ip}");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                $result=curl_exec($ch);
                if($result != ""){
                    $result=json_decode($result);
                    $ip_lat = $result->lat;
                    $ip_lon = $result->lon;
                    //insert into map_data table for faster loading in the next load of the heatmap
                    $sql_insert = "INSERT INTO `har_file_processor`.`map_data` (`serverLat`, `serverLon`, `count`, `user`, `Lat`, `Lon`) 
                    VALUES('$ip_lat', '$ip_lon', '$row[0]', '$user', '$row[2]', '$row[3]');";
                    mysqli_query($db,$sql_insert);
                    
                    $loc[] = array('lat' => $ip_lat, 'lng' => $ip_lon, 'count' => intval($row[0]));
                }
            }
        }
        $sql_count= "SELECT count(1)/10 from entries;";
        $stm = mysqli_query($db,$sql_count);
        $count = mysqli_fetch_all($stm);
        $final = array('max'=>$count, 'data'=>$loc);
        echo json_encode($final, JSON_NUMERIC_CHECK);
    } 
    
?>