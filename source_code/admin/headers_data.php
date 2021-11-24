<?php
     $db = mysqli_connect('localhost', 'root', '', 'har_file_processor') or die($db);

    if(isset($_GET["query"])){
        $query = strval($_GET["query"]);
        $provider = strval($_GET["provider"]);
        $queries = explode(",", $query);
        $query = implode("','",$queries); 
        $count = count($queries);
        if($provider == "" || $provider == "all"){
            $sql = "SELECT avg(REGEXP_SUBSTR(cache_control,'[0-9]+')),content_type from 
            (((response_headers inner join responses on  response_headers.responses_id = responses.response_id ) 
            inner join har_files on responses.id_har = har_files.har_file_id )
            inner join entries on har_files.har_file_id = entries.id_har) 
            where  response_headers.content_type IN ('$query')
            group by response_headers.content_type
            HAVING COUNT(DISTINCT response_headers.content_type) = 1;";

            $loc = array();
            $loc[] = array('Content-Type','Max-Age');

            $stmt = mysqli_query($db, $sql);
            $data = mysqli_fetch_all($stmt);
            foreach ($data as $rows) 
            {                                  
                $loc[] = array($rows[1], floatval($rows[0]));
            }
            echo json_encode($loc);
        }else{
            $sql = "SELECT avg(REGEXP_SUBSTR(cache_control,'[0-9]+')),content_type from 
            (((response_headers inner join responses on  response_headers.responses_id = responses.response_id ) 
            inner join har_files on responses.id_har = har_files.har_file_id )
            inner join entries on har_files.har_file_id = entries.id_har) 
            where  response_headers.content_type IN ('$query') and entries.provider = '$provider'
            group by response_headers.content_type
            HAVING COUNT(DISTINCT response_headers.content_type) = 1;";

            $loc = array();
            $loc[] = array('Content-Type','Max-Age');

            $stmt = mysqli_query($db, $sql);
            $data = mysqli_fetch_all($stmt);
            foreach ($data as $rows) 
            {                                  
                $loc[] = array($rows[1], floatval($rows[0]));
            }
            echo json_encode($loc);
        }
    }elseif(!isset($_GET["query"]) && isset($_GET["provider"])){

        $provider = strval($_GET["provider"]);
        $sql = "SELECT avg(REGEXP_SUBSTR(cache_control,'[0-9]+')),content_type from 
            (((response_headers inner join responses on  response_headers.id_responses_idresp = responses.response_id ) 
            inner join har_files on responses.id_har = har_files.har_file_id )
            inner join entries on har_files.har_file_id = entries.id_har) 
            where  entries.provider = '$provider'
            group by response_headers.content_type;";

            $loc = array();
            $loc[] = array('Content-Type','Max-Age');

            $stmt = mysqli_query($db, $sql);
            $data = mysqli_fetch_all($stmt);
            foreach ($data as $rows) 
            {                                  
                $loc[] = array($rows[1], floatval($rows[0]));
            }
            echo json_encode($loc);

    }
    else{

        $sql = "SELECT avg(REGEXP_SUBSTR(cache_control,'[0-9]+')),content_type from 
        (((response_headers inner join responses on  response_headers.responses_id = responses.response_id ) 
        inner join har_files on responses.id_har = har_files.har_file_id )
        inner join entries on har_files.har_file_id = entries.id_har) 
        group by response_headers.content_type;";

        $loc = array();
        $loc[] = array('Content-Type','Max-Age');

        $stmt = mysqli_query($db, $sql);
        $data = mysqli_fetch_all($stmt);
        foreach ($data as $rows) 
        {
            $loc[] = array($rows[1], floatval($rows[0]));
        }
        echo json_encode($loc);
    }   
?>