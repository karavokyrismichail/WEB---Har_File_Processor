<?php
    session_start();
    $username = "";
    $email = "";
    $errors = array();
    $errors2 = array();

    //connect to database
    $db = mysqli_connect('localhost', 'root', '', 'har_file_processor') or die($db);

    // when register button is clicked
    if (isset($_POST['register'])){
        $username = mysqli_real_escape_string($db, $_POST['username']);
        $email = mysqli_real_escape_string($db, $_POST['email']);
        $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
        $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

        // ensure that form fields are filled properly
        if (empty($username)){
            array_push($errors, "Username is required!");
        }
        if (empty($email)){
            array_push($errors, "Email is required!");
        }
        if (empty($password_1)){
            array_push($errors, "Password is required!");
        }
        if ($password_1 != $password_2){
            array_push($errors, "The two passwords do not match!");
        }

        //check if username or email are already taken
        $query1 = "SELECT * FROM users WHERE email = '$email'";
        $result1 = mysqli_query($db, $query1);
        $query2 = "SELECT * FROM users WHERE username = '$username'";
        $result2 = mysqli_query($db, $query2);

        if (mysqli_num_rows($result1) == 1){
            array_push($errors2, "This email already exists!");
        }

        if (mysqli_num_rows($result2) == 1){
            array_push($errors2, "This username has been taken!");
        }

        //if there are no errors, save user to database
        if (count($errors) == 0 && count($errors2) == 0) {
            $password = md5($password_1); //encrypt password before storing

            $sql = "INSERT INTO users (username, email, password, user_type)
                        VALUES ('$username', '$email', '$password', 'user')";
            mysqli_query($db, $sql);
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $row["email"];
            $_SESSION['succes'] = "You are now logged in";
            header('location: user/homepage.php'); //redirect to home page
            
        }
    }

    // when login button is clicked
    if (isset($_POST['login'])){
        $username = mysqli_real_escape_string($db, $_POST['username']);
        $password = mysqli_real_escape_string($db, $_POST['login_password']);

        // ensure that form fields are filled properly
        if (empty($username)){
            array_push($errors, "Username is required!");
        }
        if (empty($password)){
            array_push($errors, "Email is required!");
        }

        if (count($errors) == 0) {
            $password = md5($password); //encrypt password before comparing with the password in db


            $query_username = "SELECT * FROM users WHERE username = '$username'";
            $result_username = mysqli_query($db, $query_username);
            $row = mysqli_fetch_array($result_username,MYSQLI_ASSOC);

            if (mysqli_num_rows($result_username) == 0){
                array_push($errors2, "This user doesn't exist!");
            }

            elseif (mysqli_num_rows($result_username) == 1){
            $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
            $result = mysqli_query($db, $query);
            $row = mysqli_fetch_array($result,MYSQLI_ASSOC);

            if (mysqli_num_rows($result) == 0){
                    array_push($errors2, "Wrong password!");
                }

                if (mysqli_num_rows($result) == 1){

                    if($row['user_type']=="admin"){
                        // log user in
                        $_SESSION['username'] = $username;
                        $_SESSION['email'] = $row["email"];
                        $_SESSION['succes'] = "You are now logged in";
                        header('location: admin/basic_info.php');
                    }

                    elseif($row['user_type']=="user"){
                        // log user in
                        $_SESSION['username'] = $username;
                        $_SESSION['email'] = $row["email"];
                        $_SESSION['succes'] = "You are now logged in";
                        header('location: user/homepage.php');
                    }
                }
            }   
        }

        elseif (mysqli_num_rows($result) == 0) {
            echo '<script>alert("Invalid email or password. Please try again")</script>';
        }
    }

 
    


    // logout
    if (isset($_GET['logout'])) {
        $files = glob('har_files/*');
        foreach($files as $file){ 
            if(is_file($file)) {
            unlink($file); 
            }
        }
        session_destroy();
        unset($_SESSION['username']);
        header('location: ../login.php');
        
    }

?>