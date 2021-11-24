<?php
    session_start();
    $errors_settings = array();
?>

<?php
// Profile Settings

    $db = mysqli_connect('localhost', 'root', '', 'har_file_processor') or die($db);
    
    $email = $_SESSION['email'];

    $sql = "SELECT up_date
    FROM har_files WHERE user_email = '$email'
    ORDER BY up_date DESC";

    $stmt = mysqli_query($db, $sql);
    $row = mysqli_fetch_array($stmt,MYSQLI_ASSOC);
    $uploads_count = mysqli_num_rows($stmt);


    if($_SERVER["REQUEST_METHOD"] == "POST") {
        if(isset($_POST['new_username'])){ 
            $new_username = mysqli_real_escape_string($db, $_POST['new_username']);
            
            if (empty($new_username)){
                array_push($errors_settings, "New username is required!");
            }

            if (count($errors_settings) == 0) {
                $query1 = "SELECT * FROM users WHERE username = '$new_username'";
                $result1 = mysqli_query($db, $query1);

                if (mysqli_num_rows($result1) == 1){
                    array_push($errors_settings, "This username is being used!");
                }

                if (mysqli_num_rows($result1) == 0){
                    $sql_new = "UPDATE users 
                    SET username = '$new_username'
                    WHERE email = '$email'";
                    
                    mysqli_query($db,$sql_new);
                    $_SESSION['username'] = $new_username;
        
                    echo '<script>alert("username has been changed!")</script>';
                }
            }
        }

        if(isset($_POST['new_password_1'])){
            $new_password_1 = mysqli_real_escape_string($db, $_POST['new_password_1']);
            $new_password_2 = mysqli_real_escape_string($db, $_POST['new_password_2']);

            if (empty($new_password_1)){
                array_push($errors_settings, "New password is required!");
            }

            if ($new_password_1 != $new_password_2){
                array_push($errors_settings, "Passwords do not match!");
            }

            if (count($errors_settings) == 0) {
                $new_password = md5($new_password_1); //encrypt password before comparing with the password in db
    
                $sql_new = "UPDATE users 
                SET password = '$new_password'  
                WHERE email = '$email'";
                
                mysqli_query($db,$sql_new);
    
                echo '<script>alert("Password has been changed")</script>';
            }
        }

    }
?>    


<!DOCTYPE html>
<html>
<head>
    <title> User: <?php echo $_SESSION['username'] ?> - Profile </title>
    <link rel="stylesheet" type="text/css" href="settings.css">
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
  <img src="../logo/har2.png" style="width:100%">
  <a href="homepage.php" class="w3-bar-item w3-button w3-padding-large w3-hover-light-grey">
    <i class="fa fa-home w3-xxlarge"></i>
    <p>HOME</p>
  </a>
  <a href="#" class="w3-bar-item w3-button w3-padding-large w3-light-grey">
    <i class="fa fa-user w3-xxlarge"></i>
    <p>PROFILE</p>
  </a>
  <a href="map.php" class="w3-bar-item w3-button w3-padding-large w3-hover-light-grey">
    <i class="fa fa-map-o w3-xxlarge"></i>
    <p>MAP</p>
  </a>
  <a href="homepage.php?logout='1'.php" class="w3-bar-item w3-button w3-padding-large w3-hover-light-grey">
    <i class="fa fa-arrow-circle-left w3-xxlarge" style="color:#CC0000;"></i>
    <p>EXIT</p>
  </a>
</nav>

<!-- Navbar on small screens (Hidden on medium and large screens) -->
<div class="w3-top w3-hide-large w3-hide-medium" id="myNavbar">
  <div class="w3-bar w3-black w3-opacity w3-hover-opacity-off w3-center w3-small">
    <a href="homepage.php" class="w3-bar-item w3-button" style="width:25% !important">PROFILE</a>
    <a href="#" class="w3-bar-item w3-button" style="width:25% !important">HOME</a>
    <a href="map.php" class="w3-bar-item w3-button" style="width:25% !important">MAP</a>
    <a href="homepage.php?logout='1'.php" class="w3-bar-item w3-button" style="width:25% !important">EXIT</a>
  </div>
</div>

<!-- Page Content -->
<div class="w3-padding-large" id="main">

    <div class="w3-padding-64 w3-content w3-text-grey" id="contact">
        <h2 class="w3-text-grey">Profile Settings</h2>
        <hr style="border: 1px solid grey; border-radius: 5px; width: 18%; margin-left: 0px;">

        <?php include('settings_errors.php'); ?>

        <form  method="post" action="settings.php" >
        
            <p><input class="w3-input w3-padding-16" type="text" name = "new_username" id="new_username" 
            placeholder="New username" title = 'New username is not required.' style = "width: 70%; margin-left: 0px;"></p>

            <button type="submit" name="Change_username" id ="Change_username_button" class="btn">Change Username</button>

        </form>

        <form method="post" action="settings.php">

            <p><input class="w3-input w3-padding-16" type="password" name = "new_password_1" id = "new_password_1" 
            minlength=8 maxlength=35 pattern="(?=.*\d)(?=.)(?=.*\W)(?=.*[A-Z]).*"
            placeholder="New Password" title = 'Length: 8 - 20 & 1 uppercase letter & 1 number & 1 symbol.' style = "width: 70%; margin-left: 0px;"></p>
            
            <p><input class="w3-input w3-padding-16" type="password" name = "new_password_2" id="new_password_2" 
            placeholder="Confirm New Password" style = "width: 70%; margin-left: 0px;" onkeyup='checkPasswords();'></p>

            <div class="showpass">
            <input type="checkbox" onclick="showNewPass()"> Show Password
            </div>

            <button type="submit" name="Change_password" id ="Change_password_button" class="btn">Change Password</button>
        
        </form>

        <h2 class="w3-text-grey">Profile Information</h2>
        <hr style="border: 1px solid grey; border-radius: 5px; width: 18%; margin-left: 0px;">

        <div class="w3-section">
        <p><i class="fa fa-user-o fa-fw w3-text-grey w3-xxlarge w3-margin-right"></i> Username: <?php echo $_SESSION['username']?></p>
        <p><i class="fa fa-calendar fa-fw w3-text-grey w3-xxlarge w3-margin-right"></i> Last upload: <?php echo $row["up_date"]?></p>
        <p><i class="fa fa-files-o fa-fw w3-text-grey w3-xxlarge w3-margin-right"> </i> Number of uploads: <th><?php echo $uploads_count?></p>
        </div><br>
   
    </div>
    <script type="text/javascript" src="settings.js"></script>
    </div>
</body>
</html>


