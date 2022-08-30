<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login page</title>
    <link rel="stylesheet" href="css/login_page.css">
    <script language="javascript" type="text/javascript" src="js/data.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.12/dist/vue.js"></script>
</head>

<?php

session_start();

if (isset($_SESSION['status'])){
    $statusRegistration = $_SESSION['status'];
    //var_dump($status);
    session_unset();
}

if (isset($_SESSION['statusLogin'])){
    $status = $_SESSION['statusLogin'];
    //var_dump($status);
    session_unset();
}

?>

<body>
    
    <div class="hero">

        <div class="form-box">


            <div class="logo">
                <img src= "img/JustParkLogo.png">    
            </div>

            <div class="button-box">
                <div id="btn"></div>
                <button type="button" class="toggle-btn" onclick="login()">Log In</button>
                <button type="button" class="toggle-btn" onclick="register()">Register</button>
            </div>

            

         

            <?php
                $msg = '<br>';
                if (isset($statusRegistration) && $statusRegistration=='success'){
                    $msg = "Successful Registration!";
                }
                else if (isset($statusRegistration) && $statusRegistration=='failed') {
                    $msg = "Failed Registration!";
                }
                if (( isset($status)) && ( $status == "unsuccessful" )) {
                $msg = "Invalid Username or Password!";
                }
            ?>



            

            <div id="login" class="input-group justify-content-lg-center">            
                <form action="php/login.php" method="GET">
                    <input type="text" id="username" class="input-field" name="username" placeholder="User ID" required>
                    <input type="password" id="password" class="input-field" name="password" placeholder="Enter Password" required>
                    <br><br><p id='msg'></p><br>                
                    <button type="submit" class="button">Log In</button>
                </form>
            </div>

            <script>
            var msg = <?php echo json_encode($msg); ?>;
            console.log(msg);
            document.getElementById('msg').innerHTML = msg;
            if (msg == "Successful Registration!") {
                document.getElementById('msg').setAttribute('class', 'success')
            }

            else {
                document.getElementById('msg').setAttribute('style', 'color: red;')
            }
            </script>
            <div id = "register" class="input-group">
                <div id='vueForm'>
                    <form action="php/signup.php" method="GET">
                        <input type="text" id="username" name="username" class="input-field" placeholder="User ID" required>
                        <input type="email" id="email" name="email" class="input-field" placeholder="Enter Email" required>
                        <input v-model='password' type="password" id="password" name="password" class="input-field" placeholder="Enter Password" required>
                        <input v-model='confirm' name='confirm' id="pass" type="password" class="input-field" placeholder="Retype Password" data-type="password" required>
                        <br><br><p v-show='password!==confirm && confirm !== "" && password !== ""' style >Passwords are not the same!</p><br>
                        <button type="submit" class="button">Register</button>
                    </form>
                </div>
            </div>

            <script>
                new Vue({
                    el: '#vueForm',
                    data: {
                        password: '',
                        confirm: '',
                    }
                })
            </script>

        </div>
    </div>

    <script>

        var x = document.getElementById("login");
        var y = document.getElementById("register");
        var z = document.getElementById("btn");

        function register() {
            x.style.left= "-450px";
            y.style.left = "0px";
            z.style.left = "110px";

        }

        function login() {
            x.style.left= '0px';
            y.style.left = "450px";
            z.style.left = "0";

        }

    </script>

   

   
    
</body>
</html>