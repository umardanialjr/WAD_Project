<?php
 
// get database connection
include_once 'ConnectionManager.php';
include_once 'user.php';
include_once 'userDAO.php';
 
// get database connection
$database = new ConnectionManager();

 
// prepare user object
$dao = new userDAO();

// var_dump($_GET);

// set ID property of user to be edited
//var_dump($_GET);
$username = $_GET['username'];
$password = $_GET['password'];
$confirm = $_GET['confirm'];
$email = $_GET['email'];

if ($confirm == $password) {
    $signup = $dao-> newSignUp($username, $email, $password);
 
    // create the user
    if( $signup ){
        $user_arr=array(
            "status" => true,
            "message" => "Successfully Login!",
            "username" => $username
        );
        session_start();
        $_SESSION['status'] = "success";
        //here
        header('Location: ../loginpage.php');
        echo 'success';
        exit;
    }
    else{
        $user_arr=array(
            "status" => false,
            "message" => "Invalid Username or Password!",
        );
        session_start();
        $_SESSION['status'] = "failed";
        echo 'tried';
        header('Location: ../loginpage.php');
        exit;
    }
    print_r(json_encode($user_arr));
}

else {
    $user_arr=array(
        "status" => false,
        "message" => "Failed Registration! Passwords did not match!",
    );
    session_start();
    $_SESSION['status'] = "failed";
    echo 'wrong';
    header('Location: ../loginpage.php');
}


?>