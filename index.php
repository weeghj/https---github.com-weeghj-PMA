<?php
// load the login class
require_once("classes/Login.php");
session_start();

if(isset($_COOKIE['username']) && isset($_COOKIE['password'])) {
    $login = new Login($_COOKIE['username'], $_COOKIE['password']);
    if ($login->isUserVallid() == true) {
		$_SESSION['username'] = $_COOKIE['username'];
		//header('location:views/main.php');
        header('location:switchboard.php');
	}
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <link rel="icon" href="../../favicon.ico">
 <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
      <link rel="shortcut icon" href="images/elopak.PNG" type="image/x-icon" />
    <title>Elopak PMA Login</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/pma.css" rel="stylesheet">


  </head>
    

   <body class="index-body">  
       <div class="container">
           <div class="card card-container">
               <img id="profile-img" class="profile-img-card" src="images/logo.png"/>
               <div class="inner-addon left-addon">
                   <i class="glyphicon glyphicon-user"></i>      
                   <input type="text" id="username" class="form-control input-sm chat-input" placeholder="username" name="username" required autofocus>
                   <label>
                       <br>
                   </label>
                   <div class="inner-addon left-addon">
                       <i class="glyphicon glyphicon-lock"></i>     
                       <input type="password" id="password" class="form-control" placeholder="Password" name="password" required>
                   </div>
                   <label>
                       <br><br>
                   </label>
                   <input type="checkbox" tabindex="3" class="" id="remember" value="yes"><label for="remember"> Remember Me</label>
                   <div id="remember" class="checkbox">
                       <label>
                           <br>
                       </label>
                   </div>    
                   <span class="group-btn">  

                       <a id="loginBtn" href="#" class="btn btn-lg btn-primary btn-block btn-signin">Login</a>
                   </span>

                   </form><!-- /form -->
               </div>
           </div>
       </div>          
      
     
       
    <script>    
        $(document).ready(function(){
            $("a#loginBtn").click(function(event){
                $.ajax({
                    type: 'POST',
                    url: 'login.php',
                    data: 'username=' + $('#username').val() + '&password=' + $('#password').val() + '&remember=' + $('#remember').is(':checked'), 
                    success: function(msg) {
                        if(msg == "true") {
                            //document.location.href = "views/main.php";
                            document.location.href = "switchboard.php";
                        }
                        else {
                   
                            alert('Invaled login');
                        }
                    } 
                });
            });
        }); //Document ready
    </script>
  </body>
</html>