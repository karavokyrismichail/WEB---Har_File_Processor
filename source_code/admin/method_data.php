<?php
$db = mysqli_connect('localhost', 'root', '', 'har_file_processor') or die($db);
//for query or queries
    if(isset($_GET["query"])){
        $query = strval($_GET["query"]);
        $queries = explode(",", $query);
        $query = implode("','",$queries); 
        $count = count($queries);
        $sql = "SELECT REGEXP_SUBSTR(entries.startedDateTime,'[0-9]*:[0-9]*:[0-9]*'),avg(entries.wait_time) from 
        (entries inner join requests on entries.entry_id = requests.id_entr)
            where requests.method IN ('$query')
            group by REGEXP_SUBSTR(entries.startedDateTime,'[0-9]*:[0-9]*:[0-9]*')
            HAVING COUNT(DISTINCT requests.method) = '$count'
            order by REGEXP_SUBSTR(entries.startedDateTime,'[0-9]*:[0-9]*:[0-9]*');";

        $loc = array();

        $stmt = mysqli_query($db, $sql);
        $data = mysqli_fetch_all($stmt);
        foreach ($data as $rows) 
        {                                
            $outputString = preg_replace('/[^0-9]/', '', strval($rows[0]));
            $time = array(intval(strval($outputString[0]).strval($outputString[1])),intval(strval($outputString[2]).strval($outputString[3])),intval(strval($outputString[4]).strval($outputString[5])));                                
            $loc[] = array($time, floatval($rows[1]));
        }
        echo json_encode($loc);
    }else{
//for ALL
    $sql = "SELECT REGEXP_SUBSTR(entries.startedDateTime,'[0-9]*:[0-9]*:[0-9]*'),avg(entries.wait_time) from 
    (entries inner join requests on entries.entry_id = requests.id_entr)
     group by REGEXP_SUBSTR(entries.startedDateTime,'[0-9]*:[0-9]*:[0-9]*')
     order by REGEXP_SUBSTR(entries.startedDateTime,'[0-9]*:[0-9]*:[0-9]*');";

    $loc = array();

    $stmt = mysqli_query($db, $sql);
    $data = mysqli_fetch_all($stmt);
    foreach ($data as $rows) 
    {
        $outputString = preg_replace('/[^0-9]/', '', strval($rows[0]));
        $time = array(intval(strval($outputString[0]).strval($outputString[1])),intval(strval($outputString[2]).strval($outputString[3])),intval(strval($outputString[4]).strval($outputString[5])));                                 
        $loc[] = array($time, floatval($rows[1]));
    }
    echo json_encode($loc);
    }   
?>