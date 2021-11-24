<?php
   include('../server.php');
   $errors_settings = array();
?>


<?php
// getting basic info from database
    $db = mysqli_connect('localhost', 'root', '', 'har_file_processor') or die($db);

    //number of users
    $sql = "SELECT COUNT(email)
    FROM users WHERE user_type = 'user';";
    $result = mysqli_query($db, $sql);
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);

    //number of methods
    $sql1 = "SELECT COUNT(request_id), method
    FROM requests GROUP BY method;";
    $result1 = mysqli_query($db, $sql1);

    //number of status
    $sql2 = "SELECT COUNT(response_id), status_field
    FROM responses GROUP BY status_field;";
    $result2 = mysqli_query($db, $sql2);

    //number of unique domains
    $sql3 = "SELECT COUNT(request_id), domain_url
    FROM requests GROUP BY domain_url;";
    $result3 = mysqli_query($db, $sql3);

    //numer of supliers
    $sql4 = "SELECT COUNT(entry_id), provider
    FROM entries GROUP BY provider;";
    $result4 = mysqli_query($db, $sql4);

    //avg content type
    $sql5 = "SELECT avg(age),content_type 
    FROM response_headers GROUP BY content_type;";
    $result5 = mysqli_query($db, $sql5);
?>


<!DOCTYPE html>
<html>
<head>
    <title> Admin: <?php echo $_SESSION['username'] ?> - Basic Infromation </title>
    <link rel="stylesheet" type="text/css" href="basic_info.css">

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

<body class="w3-light-grey">
<div class="content">
        <?php if (isset($_SESSION['success'])): ?>
            <div class="error success">
                <h3>
                    <?php
                        echo $_SESSION['success'];
                        unset($_SESSION['success'])
                    ?>
                </h3>
             </div>
        <?php endif ?>
    
  <!-- Icon Bar (Sidebar - hidden on small screens) -->
<nav class="w3-sidebar w3-bar-block w3-small w3-hide-small w3-center">
  <!-- Avatar image in top left corner -->
  <img src="../logo/har2.png" style="width:100%">
  <a href="#" class="w3-bar-item w3-button w3-padding-large w3-light-grey">
    <i class="fa fa-info-circle w3-xxlarge"></i>
    <p>BASIC INFORMATION</p>
  </a>
  <a href="response_time.php" class="w3-bar-item w3-button w3-padding-large w3-hover-light-grey">
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
  <div class="w3-bar w3-black w3-opacity w3-hover-opacity-off w3-center w3-small">
  <a href="#" class="w3-bar-item w3-button" style="width:25% !important">BASIC INFORMATION</a>
    <a href="response_time.php" class="w3-bar-item w3-button" style="width:25% !important">RESPONSE-TIME ANALYSIS</a>
    <a href="headers.php" class="w3-bar-item w3-button" style="width:25% !important">HTTP ANALYSIS</a>
    <a href="net_map.php" class="w3-bar-item w3-button" style="width:25% !important">NET-MAP</a>
    <a href="basic_info.php?logout='1'.php" class="w3-bar-item w3-button" style="width:25% !important">EXIT</a>
  </div>
</div>

<!-- Page Content -->
<div class="w3-padding-large" id="main">

    <header class="w3-container w3-padding-32 w3-center w3-light-grey" id="home">
                <div class = "title">
                    <h1 class="w3-jumbo"><span class="w3-hide-small">Admin: <strong><?php echo $_SESSION['username'];?></h1>
                </div>
    </header>

    <div class="w3-padding-64 w3-content w3-text-grey" id="contact">
        <h2 class="w3-text-dark-grey">Basic Information</h2>
        <hr style="border: 1px solid grey; border-radius: 5px; width: 18%; margin-left: 0px;">

    <table id="tables">
        <tr>
            <th>Number of users:</th>
            <th><?php echo $row["COUNT(email)"]?></th>
        </tr>
    </table>
 <!---------------------------------------------------------------------------------------------------------------------->
    <table id="tables">
        <tr>
            <th>Methods</td>
            <th>count</td>
        </tr>
       <!-- PHP CODE TO FETCH DATA FROM ROWS-->
       <?php   // LOOP TILL END OF DATA 
                while($rows1=$result1->fetch_assoc())
                {
             ?>
            <tr>
                <!--FETCHING DATA FROM EACH 
                    ROW OF EVERY COLUMN-->
                <td><?php echo $rows1['method'];?></td>
                <td><?php echo $rows1['COUNT(request_id)'];?></td>
            </tr>
            <?php
                }
             ?>
        </table>
 <!---------------------------------------------------------------------------------------------------------------------->
    <table id="tables">
        <tr>
            <th>Status</td>
            <th>count</td>
        </tr>
       <!-- PHP CODE TO FETCH DATA FROM ROWS-->
       <?php   // LOOP TILL END OF DATA 
                while($rows2=$result2->fetch_assoc())
                {
             ?>
            <tr>
                <!--FETCHING DATA FROM EACH 
                    ROW OF EVERY COLUMN-->
                <td><?php echo $rows2['status_field'];?></td>
                <td><?php echo $rows2['COUNT(response_id)'];?></td>
            </tr>
            <?php
                }
             ?>
        </table>
 <!---------------------------------------------------------------------------------------------------------------------->
    <table id="tables">
        <tr>
            <th>Domains</td>
            <th>count</td>
        </tr>
       <!-- PHP CODE TO FETCH DATA FROM ROWS-->
       <?php   // LOOP TILL END OF DATA 
                while($rows3=$result3->fetch_assoc())
                {
             ?>
            <tr>
                <!--FETCHING DATA FROM EACH 
                    ROW OF EVERY COLUMN-->
                <td><?php echo $rows3['domain_url'];?></td>
                <td><?php echo $rows3['COUNT(request_id)'];?></td>
            </tr>
            <?php
                }
             ?>
        </table>
 <!---------------------------------------------------------------------------------------------------------------------->
    <table id="tables">
        <tr>
            <th>Supliers</td>
            <th>count</td>
        </tr>
       <!-- PHP CODE TO FETCH DATA FROM ROWS-->
       <?php   // LOOP TILL END OF DATA 
                while($rows4=$result4->fetch_assoc())
                {
             ?>
            <tr>
                <!--FETCHING DATA FROM EACH 
                    ROW OF EVERY COLUMN-->
                <td><?php echo $rows4['provider'];?></td>
                <td><?php echo $rows4['COUNT(entry_id)'];?></td>
            </tr>
            <?php
                }
             ?>
        </table>
 <!---------------------------------------------------------------------------------------------------------------------->
    <table id="tables">
        <tr>
            <th>Content type</td>
            <th>Average Age</td>
        </tr>
       <!-- PHP CODE TO FETCH DATA FROM ROWS-->
       <?php   // LOOP TILL END OF DATA 
                while($rows5=$result5->fetch_assoc())
                {
             ?>
            <tr>
                <!--FETCHING DATA FROM EACH 
                    ROW OF EVERY COLUMN-->
                <td><?php echo $rows5['content_type'];?></td>
                <td><?php echo $rows5['avg(age)'];?></td>
            </tr>
            <?php
                }
             ?>
        </table>

    </div>
</div>
</body>
</html>
