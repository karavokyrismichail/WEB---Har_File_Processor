<?php
    session_start();
    ini_set('max_execution_time', 300);

        
    $user = $_SESSION['email'];
    $loc = array();

    $db = mysqli_connect('localhost', 'root', '', 'har_file_processor') or die($db);

    $sql_stored = "SELECT *
    FROM `har_file_processor`.`map_data` order by 'count' desc;";
    $stored = mysqli_query($db,$sql_stored);
    $dataS = mysqli_fetch_all($stored);
    foreach ($dataS as $rows) 
    {                                
        $loc[] = array('lat' => floatval($rows[0]), 'lng' => floatval($rows[1]), 'count' => intval($rows[2]), 'ulat' => floatval($rows[4]), 'ulng' => floatval($rows[5]));
    }
     
    echo json_encode($loc);

    
?>