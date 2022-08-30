<?php
// include database and object files
include_once 'ConnectionManager.php';
include_once 'user.php';
include_once 'userDAO.php';
 
// get database connection
$database = new ConnectionManager();

 
// prepare user object
$dao = new userDAO();

// var_dump($_GET);

// set ID property of user to be edited
$username = $_GET['username'];
$password = $_GET['password'];

// $user->username = isset($_GET['username']) ? $_GET['username'] : die();
// $user->password = isset($_GET['password']) ? $_GET['password'] : die();
// read the details of user to be edited

$dao = new userDAO();
// Check out AccountDAO's register($username, $hashed_password) method
// How do I encrypt $password and save it into $hashed_password?
// HINT: password_hash()
// After encrypting, call register($username, $hashed_password)
// What does register() return? TRUE? FALSE?

$login = $dao->login($username);

if ($login == $_GET['password']){
     $user_arr=array(
        "status" => true,
        "message" => "Successfully Login!",
        "username" => $username
    );
    session_start();
    $_SESSION['username'] = $username;
    header('Location: ../search.php');
    exit;
} else {

    session_start();
    $_SESSION['statusLogin'] = "unsuccessful";
    header('Location: ../loginpage.php');
    exit;
}
    

var_dump($user_arr);

// make it json format

//Send the userarray here. 

echo "<a href='../search.php' >Continue</a>";

?>

