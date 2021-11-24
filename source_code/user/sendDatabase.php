<?php
   session_start();

$db = mysqli_connect('localhost', 'root', '', 'har_file_processor') or die($db);  
 
// Get user's IP information
$ch =curl_init();
curl_setopt($ch, CURLOPT_URL, "http://ip-api.com/json");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$result=curl_exec($ch);
$result=json_decode($result);
if ($result->status=='success') { 
  $ipaddress = $result->query;
  $ip_lat = $result->lat;
  $ip_lon = $result->lon;
  $ip_org = $result->org;
}

$sql = "INSERT INTO `har_file_processor`.`requests` ( `method`, `domain_url`,`id_har`,`id_entr`) VALUES('$method', '$domain','$har_id','$entry_id' );";

// Get the contents of the JSON file 
$strJsonFileContents = file_get_contents($_SESSION['cur_file']);
$data = json_decode($strJsonFileContents, true);

// Insert into Har table
$file_url = $_SESSION['cur_file'];
$up_date = date("Y-m-d");
$user_email = $_SESSION['email'];
$sql = "INSERT INTO `har_file_processor`.`har_files` (`file_url`, `up_date`, `user_email`) VALUES('$file_url', '$up_date', '$user_email');";
mysqli_query($db, $sql);
$har_id = $db->insert_id;

// Insert into entries table
foreach( $data['log']['entries'] as $row ) {

    echo "hello";

    $wday = date("w");
    $serverIP = $row['serverIPAddress'];
    $startedDateTime = $row['startedDateTime'];
    $wait_time = $row['timings']['wait'];
    $sql = "INSERT INTO `har_file_processor`.`entries` (`serverIPAddress`, `startedDateTime`, `wait_time`, `id_har`, `provider`, `dayofWeek`, `langitude`, `longitude`) VALUES('$serverIP', '$startedDateTime', '$wait_time', '$har_id', '$ip_org', '$wday', '$ip_lat', '$ip_lon');";
    mysqli_query($db, $sql);
    $entry_id = $db->insert_id;

    // Insert into requests and reqheaders table
    $method = $row['request']['method'];
    $domain = $row['request']['url'];
    $domain = str_replace("https://", '', $domain);
    $domain = substr($domain, 0, strpos($domain, "/"));
    $sql = "INSERT INTO `har_file_processor`.`requests` ( `method`, `domain_url`,`id_har`,`id_entr`) VALUES('$method', '$domain','$har_id','$entry_id' );";
    mysqli_query($db, $sql);
    $req_id = $db->insert_id;
    foreach( $row['request']['headers'] as $heads ) {

        if($heads['name'] === "Host"){

            $host = $heads['value'];
            $sqlH = "INSERT INTO `har_file_processor`.`request_headers` (`host_field`, `reqs_id`) VALUES('$host', '$req_id');";
            mysqli_query($db, $sqlH);

        }
    }          
}

// Insert into responses and rheaders table
foreach( $data['log']['entries'] as $row ) {

    $status = $row['response']['status'];
    $status_text = $row['response']['statusText'];
    $sql = "INSERT INTO `har_file_processor`.`responses` (`id_har`, `status_field`, `status_text`) VALUES('$har_id', '$status', '$status_text');";
    mysqli_query($db, $sql);
    $res_id = $db->insert_id;
    foreach( $row['response']['headers'] as $heads ) {
        

        if(strtolower($heads['name']) === "content-type"){
            $content = $heads['value'];
        }
        if(strtolower($heads['name']) === "cache-control"){
            $cache = $heads['value'];
        }
        if(strtolower($heads['name']) === "pragma"){
            $pragma = $heads['value'];
        }
        if(strtolower($heads['name']) === "expires"){
            $expires = $heads['value'];
        }
        if(strtolower($heads['name']) === "last-modified"){
            $lastmod = $heads['value'];
        }
        if(strtolower($heads['name']) === "age"){
            $age = $heads['value'];
        }
        
    }
    $sqlH = "INSERT INTO `har_file_processor`.`response_headers` (`content_type`, `cache_control`, `pragma`, `expires`, `last_modified`, `age`, `responses_id`) VALUES('$content','$cache','$pragma','$expires','$lastmod','$age', '$res_id');";
    mysqli_query($db, $sqlH);
    
    
}
// Use unlink() function to delete the file  
if (!unlink($_SESSION['cur_file'])) {  
    echo ("cannot be delete due to an error");  
}  
else {  
    echo ("has been deleted");  
}  
?>