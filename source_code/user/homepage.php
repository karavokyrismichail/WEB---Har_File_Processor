<?php include('../server.php');?>
<!DOCTYPE html>
<html>
    <head>
    <title> User: <?php echo $_SESSION['username'] ?> - Homepage </title>
    <link href="map.css" rel="stylesheet" type="text/css">
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
        
        <?php if (isset($_SESSION["username"])): ?>

            <!-- Icon Bar (Sidebar - hidden on small screens) -->
<nav class="w3-sidebar w3-bar-block w3-small w3-hide-small w3-center">
  <!-- Avatar image in top left corner -->
  <img src="../logo/har2.png" style="width:100%">
  <a href="#" class="w3-bar-item w3-button w3-padding-large w3-light-grey">
    <i class="fa fa-home w3-xxlarge"></i>
    <p>HOME</p>
  </a>
  <a href="settings.php" class="w3-bar-item w3-button w3-padding-large w3-hover-light-grey">
    <i class="fa fa-user w3-xxlarge"></i>
    <p>PROFILE</p>
  </a>
  <a href="map.php" class="w3-bar-item w3-button w3-padding-large w3-hover-light-grey">
    <i class="fa fa-map-o w3-xxlarge"></i>
    <p>MAP</p>
  </a>
  <a href="homepage.php?logout='1'" class="w3-bar-item w3-button w3-padding-large w3-hover-light-grey">
    <i class="fa fa-arrow-circle-left w3-xxlarge" style="color:#CC0000;"></i>
    <p>EXIT</p>
  </a>
</nav>

<!-- Navbar on small screens (Hidden on medium and large screens) -->
<div class="w3-top w3-hide-large w3-hide-medium" id="myNavbar">
  <div class="w3-bar w3-black w3-opacity w3-hover-opacity-off w3-center w3-small">
    <a href="#" class="w3-bar-item w3-button" style="width:25% !important">HOME</a>
    <a href="settings.php" class="w3-bar-item w3-button" style="width:25% !important">PROFILE</a>
    <a href="map.php" class="w3-bar-item w3-button" style="width:25% !important">MAP</a>
    <a href="homepage.php?logout='1'" class="w3-bar-item w3-button" style="width:25% !important">EXIT</a>
  </div>
</div>

<!-- Page Content -->
<div class="w3-padding-large" id="main">
      <!---- TITLE ---->
      <!-- Header/Home -->
      <header class="w3-container w3-padding-32 w3-center w3-light-grey" id="home">
        <div class = "title">
            <h1 class="w3-jumbo"><span class="w3-hide-small">Welcome user: <strong><?php echo $_SESSION['username'];?></h1>
        </div>
    </header>

          <!---------------------------------------------------------------------------------------------------------------------->
    <div class="w3-padding-64 w3-content w3-text-grey" id="contact">
        <h2 class="w3-text-grey" style="text-align: center" >Upload Har File</h2>
        <hr style="width:200px" class="w3-opacity" style="color:#CC0000;">
          <?php include('upload_file.php');?>

    <?php endif ?>
    </div>
</div>

<!-- END PAGE CONTENT -->
</div>
</body>
<script src="jquery-3.6.0.js"></script>
</html>