<?php include('../server.php');?>
<!DOCTYPE html>
<html>
    <head>
    <title> User: <?php echo $_SESSION['username'] ?> - map </title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- MAP -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
   crossorigin=""/>
      <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
      integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
      crossorigin=""></script>
      <script
      src="https://cdn.jsdelivr.net/npm/heatmapjs@2.0.2/heatmap.js"> </script>
      <script
      src="leaflet-heatmap.js"> </script>
    <!-- MAP -->
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
      <!-- Icon Bar (Sidebar - hidden on small screens) -->
<nav class="w3-sidebar w3-bar-block w3-small w3-hide-small w3-center">
  <!-- Avatar image in top left corner -->
  <img src="../logo/har2.png" style="width:100%">
  <a href="homepage.php" class="w3-bar-item w3-button w3-padding-large w3-hover-light-grey">
    <i class="fa fa-home w3-xxlarge"></i>
    <p>HOME</p>
  </a>
  <a href="settings.php" class="w3-bar-item w3-button w3-padding-large w3-hover-light-grey">
    <i class="fa fa-user w3-xxlarge"></i>
    <p>PROFILE</p>
  </a>
  <a href="#" class="w3-bar-item w3-button w3-padding-large w3-light-grey">
    <i class="fa fa-map-o w3-xxlarge"></i>
    <p>HEAT-MAP</p>
  </a>
  <a href="homepage.php?logout='1'" class="w3-bar-item w3-button w3-padding-large w3-hover-light-grey">
    <i class="fa fa-arrow-circle-left w3-xxlarge" style="color:#CC0000;"></i>
    <p>EXIT</p>
  </a>
</nav>

<!-- Navbar on small screens (Hidden on medium and large screens) -->
<div class="w3-top w3-hide-large w3-hide-medium" id="myNavbar">
  <div class="w3-bar w3-black w3-opacity w3-hover-opacity-off w3-center w3-small">
    <a href="homepage.php" class="w3-bar-item w3-button" style="width:25% !important">HOME</a>
    <a href="settings.php" class="w3-bar-item w3-button" style="width:25% !important">PROFILE</a>
    <a href="#" class="w3-bar-item w3-button" style="width:25% !important">HEAT-MAP</a>
    <a href="homepage.php?logout='1'" class="w3-bar-item w3-button" style="width:25% !important">EXIT</a>
  </div>
</div>

<!-- Page Content -->
<div class="w3-padding-large" id="main">
<div class="w3-padding-64 w3-content w3-text-grey" id="contact">
        <h2 class="w3-text-dark-grey" style="text-align: center;">HEAT-MAP</h2>
        <hr style="width:100px, margin-left: 30px; border: 1px solid grey; border-radius: 5px;">
        </div>
          <div class="map">
          <div id="mapid" style="width: 100%; height: 800px;"></div>
          </div>


</body>
<script src="map.js"></script>
<script src="jquery-3.6.0.js"></script>
</html>