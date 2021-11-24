<?php include('server.php'); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Har-file-Processor | Login</title>
    <link rel="stylesheet" type="text/css" href="register.css">
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
    <!-- Icon Bar (Sidebar - hidden on small screens) -->
<nav class="w3-sidebar w3-bar-block w3-small w3-hide-small w3-center">
  <!-- Avatar image in top left corner -->
  <img src="logo/har2.png" style="width:100%">
  <a href="#" class="w3-bar-item w3-button w3-padding-large w3-light-grey">
    <i class="fa fa-user-circle w3-xxlarge"></i>
    <p>Sign In</p>
  </a>
  <a href="register.php" class="w3-bar-item w3-button w3-padding-large w3-hover-light-grey">
    <i class="fa fa-address-card-o w3-xxlarge"></i>
    <p>Sign Up</p>
  </a>
</nav>

<!-- Navbar on small screens (Hidden on medium and large screens) -->
<div class="w3-top w3-hide-large w3-hide-medium" id="myNavbar">
  <div class="w3-bar w3-light-grey w3-opacity w3-hover-opacity-off w3-center w3-small">
    <a href="#" class="w3-bar-item w3-button" style="width:25% !important">Sign In</a>
    <a href="register.php" class="w3-bar-item w3-button" style="width:25% !important">Sign Up</a>
  </div>
</div>


<!-- Page Content -->
<div class="w3-padding-large" id="main">
        <header class="w3-container w3-padding-32 w3-center w3-light-grey" id="home">
            <div class = "title">
                <h1 class="w3-jumbo"><span class="w3-hide-small">Har-File-Processor <strong></h1>
            </div>
        </header>

    <div class="w3-padding-64 w3-content w3-text-grey" id="contact">
            <h2 class="w3-text-grey">Login</h2>
            <hr style="border: 1px solid grey; border-radius: 5px; width: 18%; margin-left: 0px;">

             <!-- display errors here -->
            <?php include('errors.php'); ?>

        <form method="post" action="login.php">
            
                <p><input class="w3-input w3-padding-16" type="text" name = "username" placeholder="Username" 
                style = "width: 70%; margin-left: 0px;"required> </p>
            
                </p><input class="w3-input w3-padding-16" type="password" name = "login_password" 
                id ="login_password" placeholder="Password"  style = "width: 70%; margin-left: 0px;" required></p>
            

            <div class="showPass">
                <input type="checkbox" onclick="showPass()"> Show Password
                <script>
                function showPass(){
                var pass = document.getElementById("login_password")
                if (pass.type === "password") {
                    pass.type = "text";
                } else {
                    pass.type = "password";
                    }
                }
                </script>
                </div>

                <button type="submit" name="login" class="btn">Login</button>
          
        </form>
    </div>
</div>
</body>
</html>