<?php

session_start();

if(isset($_FILES['file']['name'])){
   // file name
   $filename = $_FILES['file']['name'];
   
   // Location
   $location = 'har_files/'.$filename;
   $_SESSION['cur_file'] = $location;


   // file extension
   $file_extension = pathinfo($location, PATHINFO_EXTENSION);
   $file_extension = strtolower($file_extension);

   // Valid extensions
   $valid_ext = array("har");
   
   $response = 0;
   if(in_array($file_extension,$valid_ext)){
      // Upload file
      if(move_uploaded_file($_FILES['file']['tmp_name'],$location)){
         $response = 1;
      } 
   }

   echo $response;

   // Get filtered har data  
   $data = $_POST["data"];
   // overwrite file with filtered data from js
   $f = fopen($location,"wa+"); 
   fwrite($f, $data);
   fclose($f);

   exit;
}
?>