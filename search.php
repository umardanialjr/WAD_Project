<!DOCTYPE html>
<html lang="en">
<head>


    <meta charset="utf-8">
    <title>ParkIt Website</title>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <script src='js/desired.js'></script>  
    <script src="js/frontpage.js"></script>
    <script>
        header("Cache-Control: no-store, no-cache, must-revalidate"); //HTTP/1.1
    </script>

</head>

<?php
    require_once 'php/userDAO.php';
    require_once 'php/user.php';

    session_start();
    if (!isset($_SESSION['username'])) {
        header('Location: loginpage.php');
    }

    else {
        $username = $_SESSION['username'];
    

        $dao = new userDAO();
        
        $userInformation = $dao->getUsersbyUsername($username);
        //var_dump($userInformation);
        foreach($userInformation as $user ) {
            $username = $user->getUsername();
            $email = $user->getEmail();
            $password = $user->getPassword();
            $searchHistory = $user->getSearchHistory();
            $favourite = $user->getFavourite();
            $data = [$username, $email, $password, $searchHistory, $favourite] ;
        }
    }

?>

<script>
    var data = <?php echo json_encode($data); ?>;
        console.log(data);
        var username = data[0];
        console.log(username);

        if (data[3].length != 0 ) {
            var locationHistory = data[3].split(",");
        } else {
            var locationHistory =[];
        }

        if (data[4].length != 0 ) {
            var locationFavourites = data[4].split(",");
        } else {
            var locationFavourites =[];
        }
        
        // console.log(locationFavourites);

</script>

<body onload="populate()">


<style>
    
    #address {
        width: 100%;
        margin:auto;
        box-shadow: 5px;
        
    }

    .jumbotron{
        background:none;
        padding:30px;
        /* min-height: 100vh; */
    }

    
    #submitButton{
        margin-top:20px;
        width:60%;
    }

    .main{
       
        background-image: url('img/backgrounddarker.png');
        width:100%;
        background-size: cover;
        background-repeat: no-repeat;
        min-height: 100vh;

    }

    .btn_search{
        background:linear-gradient(to right, #135ebd, #023246);
        border:none;
        display: block;
        margin: 0px auto;
    }


    @media screen and (min-width: 601px) {
    h1 {
        font-size: 100px;
    }
    }

    @media screen and (max-width: 600px) {
    h1 {
        font-size: 30px;
    }
    }

</style>




<!-- Navigation -->
    <div class="main">

        <?php require_once 'navbarbar.html'?>



    <!-- Introduction -->
    
        <div class="jumbotron bg-none jumbotron-fluid text-white text-center" id="content" >
            
            <p class="text-center display-3" style='padding-top: 100px'>Hello <?php echo ucfirst($data[0]) ?> </p>
            <p class="font-weight-bold display-2 text-center" style="font-size: medium; padding-top: 10px;">
                <b>JustPark</b>. Informing you on the latest parking availabilities
            </p>

        </div>

        <div class="container">

            <input type="text" class="form-control" id="address" placeholder="Where would you like to park" style="width: 100%;">
            <button type="submit" class="btn btn-primary btn_search" id="submitButton" onclick="desired_location(document.getElementById('address').value)"><a id='a' href='information.php' style='color: white;'onclick="addtoSearchHistory()">Find me a parking space</a></button>

            <div class='row'>

                <div class="col-lg" id="tablehistory" style='padding-top: 60px'>
                
                </div>

                <div class="col-lg-6" id="tablefavourite" style='padding-top: 60px'>
                
                </div>
            </div>
            

            <script>
                var input1 = document.getElementById("address");
                input1.addEventListener("keyup", function(event) {
                    if (event.keyCode === 13) {
                        event.preventDefault();
                        document.getElementById("a").click();
                    }
                })

            </script>

            

        </div> 
        


        <div>


        </div>

        

    </div>
  




<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>


</body>
</html>