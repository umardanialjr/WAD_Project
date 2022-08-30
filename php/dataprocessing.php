


<?php

require_once "userDAO.php";

$dao = new userDAO();


$status = false;


if (isset($_GET['removeFromFavourite'])){
    // echo"it is here";
    // var_dump($_GET['favourite']);
    // url decode.

    $status = true; 
    // make the change to database here. 
    // call the things   
    
    $username = $_GET['username'];
    $favourite = $_GET['removeFromFavourite'];
    
    $username= urldecode($username);
    $favourite= urldecode($favourite);    

    $user = $dao ->favouriteChange($username , $favourite);
       

}

if (isset($_GET['favourite'])){
    // echo"it is here";
    // var_dump($_GET['favourite']);
    // url decode.

    $status = true; 
    // make the change to database here. 
    // call the things   
    
    $username = $_GET['username'];
    $favourite = $_GET['favourite'];
    $searchReturn = $_GET['searchReturn'];


    $username= urldecode($username);
    $favourite= urldecode($favourite);
    $searchReturn = urldecode($searchReturn);
    

    $user = $dao ->favouriteChange($username , $favourite);
    $user = $dao ->searchHistoryChange($username, $searchReturn);
    

}

if ( isset($_GET['searchReturn'])){

    $status = true;
    $username = $_GET['username'];
    $searchReturn = $_GET['searchReturn'];

    $username= urldecode($username);
    $searchReturn = urldecode($searchReturn);
    
    $user = $dao ->searchHistoryChange($username, $searchReturn);
}

if ($user)
    $result["status"] = "Favourite has been added successfully";
else 
    $result["status"] = "Favourite was not added";

$postJSON = json_encode($result);



echo $postJSON;
echo $usernameJSON;

?>