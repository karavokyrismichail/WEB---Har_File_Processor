<?php
    include('../server.php');

    $db = mysqli_connect('localhost', 'root', '', 'har_file_processor') or die($db);
//for selector
    $sql1 = "SELECT content_type from response_headers group by content_type;";
    $stmt1 = mysqli_query($db, $sql1);
    $cont = mysqli_fetch_all($stmt1);

    $sql2 = "SELECT dayofWeek from entries group by dayofWeek order by dayofWeek;";
    $stmt2 = mysqli_query($db, $sql2);
    $days = mysqli_fetch_all($stmt2);
    $daysofWeek = array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday");

    $sql3 = "SELECT method from requests group by method;";
    $stmt3 = mysqli_query($db, $sql3);
    $methods = mysqli_fetch_all($stmt3);

    $sql4 = "SELECT provider from entries group by provider;";
    $stmt4 = mysqli_query($db, $sql4);
    $providers= mysqli_fetch_all($stmt4);
?>

<!DOCTYPE html>
<html">
   <head>
    <title> Admin: <?php echo $_SESSION['username'] ?> - Response Time Analysis </title>
    <link href="response_time.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        body, h1,h2,h3,h4,h5,h6 {font-family: "Montserrat", sans-serif}
        .w3-row-padding img {margin-bottom: 12px}
        /* Set the width of the sidebar to 120px */
        .w3-sidebar {width: 120px;background: #CDCDCD;}
        /* Add a left margin to the "page content" that matches the width of the sidebar (120px) */
        #main {margin-left: 120px}
        /* Remove margins from "page content" on small screens */
        @media only screen and (max-width: 600px) {#main {margin-left: 0}}
    </style>
   </head>
   <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script> 
   <script src="../user/jquery-3.6.0.js"> </script> 
   <script src="response_time.js"></script>

<body class="w3-light-grey">

  <!-- Icon Bar (Sidebar - hidden on small screens) -->
<nav class="w3-sidebar w3-bar-block w3-small w3-hide-small w3-center">
  <!-- Avatar image in top left corner -->
  <img src="../logo/har2.png" style="width:100%">
  <a href="basic_info.php" class="w3-bar-item w3-button w3-padding-large w3-hover-light-grey">
    <i class="fa fa-info-circle w3-xxlarge w3-xxlarge"></i>
    <p>BASIC INFORMATION</p>
  </a>
  <a href="#" class="w3-bar-item w3-button w3-padding-large w3-light-grey">
    <i class="fa fa-bar-chart w3-xxlarge"></i>
    <p>RESPONSE-TIME ANALYSIS</p>
  </a>
  <a href="headers.php" class="w3-bar-item w3-button w3-padding-large w3-hover-light-grey">
    <i class="fa fa-area-chart w3-xxlarge"></i>
    <p>HTTP ANALYSIS</p>
  </a>
  <a href="net_map.php" class="w3-bar-item w3-button w3-padding-large w3-hover-light-grey">
    <i class="fa fa-map-o w3-xxlarge"></i>
    <p>NET-MAP</p>
  </a>

  <a href="basic_info.php?logout='1'.php" class="w3-bar-item w3-button w3-padding-large w3-hover-light-grey">
    <i class="fa fa-arrow-circle-left  w3-xxlarge" style="color:#CC0000;"></i>
    <p>EXIT</p>
  </a>
</nav>

<!-- Navbar on small screens (Hidden on medium and large screens) -->
<div class="w3-top w3-hide-large w3-hide-medium" id="myNavbar">
  <div class="w3-bar w3-grey w3-opacity w3-hover-opacity-off w3-center w3-small">
  <a href="admin_homepage.php?logout='1'.php" class="w3-bar-item w3-button" style="width:25% !important">BASIC INFORMATION</a>
    <a href="#" class="w3-bar-item w3-button" style="width:25% !important">RESPONSE-TIME ANALYSIS</a>
    <a href="headers.php" class="w3-bar-item w3-button" style="width:25% !important">HTTP ANALYSIS</a>
    <a href="net_map.php" class="w3-bar-item w3-button" style="width:25% !important">NET-MAP</a>
    <a href="basic_info.php?logout='1'.php" class="w3-bar-item w3-button" style="width:25% !important">EXIT</a>
  </div>
</div>

<!-- Page Content -->
<div class="w3-padding-large" id="main">
<div class="w3-padding-64 w3-content w3-text-grey" id="contact">
        <h2 class="w3-text-dark-grey"  style="text-align: center;">RESPONSE-TIME ANALYSIS</h2>
        <hr style="width:100px, margin-left: 30px; border: 1px solid grey; border-radius: 5px;">
        </div>
      <section class="forms-section">
         <div class="chart" id="chart"></div>
            <div class="w3-bar w3-light-grey">
        <!---- Selectors ---->
              <!---- Content Type ---->
                    <select name="content-type" id="content-type" multiple="multiple" style = "border-color: #000080; background: #F0F8FF">
                    <option>Select Content-Type:</option>
                    <option value="all">ALL</option>
                    <?php
                    foreach($cont as $row) {
                    ?>
                        <option value="<?php echo $row[0];?>"><?php echo $row[0];?></option>
                    <?php
                    }
                    ?>
                    </select>
                    <input type="button" value="Show" style = "border-radius: 25px; margin-left:10px; 
                    margin-right:170px; color: white; background-color: #000080; border-color: #F0F8FF;" onclick="check();">
              <!---- Day ---->
                    <select name="dayofWeek" id="dayofWeek" style = "border-color: #000080; background: #F0F8FF">
                    <option>Select day: </option>
                    <option value="all">ALL</option>
                    <?php
                    foreach($days as $row) {
                    ?>
                        <option value="<?php echo $daysofWeek[intval($row[0])];?>"><?php echo $daysofWeek[intval($row[0])];?></option>
                    <?php
                    }
                    ?>
                    </select>
              <!---- Method ---->
                    <select name="method" id="method" multiple="multiple" style = "border-color: #000080; background: #F0F8FF; margin-left:170px;" >
                    <option>Select HTTP Method:</option>
                    <option value="all">ALL</option>
                    <?php
                    foreach($methods as $row) {
                    ?>
                        <option value="<?php echo $row[0];?>"><?php echo $row[0];?></option>
                    <?php
                    }
                    ?>
                    </select>
                    <input type="button" value="Show" style = "border-radius: 25px; margin-left:10px; 
                    margin-right:170px; color: white; background-color: #000080; border-color: #F0F8FF;" onclick="checkM();">
             <!---- Provider ---->
                    <select name="provider" id="provider" style = "border-color: #000080; background: #F0F8FF">
                    <option>Select Provider:</option>
                    <option value="all">ALL</option>
                    <?php
                    foreach($providers as $row) {
                    ?>
                        <option value="<?php echo $row[0];?>"><?php echo $row[0];?></option>
                    <?php
                    }
                    ?>
                    </select>
                    </div>
            </div>
         </div>
      </section>
   </body>
</html>
