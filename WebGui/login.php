<?php
session_start();
include("config.php");
if (isset($_SESSION['login']) AND $_SESSION['login']==1) {
    header("location: index.php");
    die;
}
if (isset($_POST) AND isset($_POST['username']) AND isset($_POST['password'])) {
    if (isset($utenti[strtolower($_POST['username'])]) AND $utenti[strtolower($_POST['username'])]==sha1($_POST['password'])) {
        $_SESSION['login'] = 1;
        $_SESSION['username'] = $_POST['username'];
        header("location: index.php");
    	die;
    }
    else {
        $errorlogin = 1;
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>RaspiTimeLapse</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1"/>
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
        <style>
        body,h1 {font-family: "Montserrat", sans-serif}
        body,html {height: 100%; width: 100%; margin:0}
        #alert {
            width: 350px;
            height: 60px;
        }
        #loginform {
            width: 50%;
        }
        @media screen
          and (min-width: 100px)
          and (max-width: 667px) {
              #alert {
                  width: 250px;
                  height: 100px;
              }
              #loginform {
                  width: 90%;
                  margin-top: 80px;
              }
        }
        </style>
    </head>
    <body>
        <div id="content" style="height:100%">
            <div class="w3-container w3-blue w3-xlarge w3-padding-16">
                <span class="w3-left w3-padding">RaspiTimeLapse</span>
            </div>
            <div class="w3-content w3-center w3-margin-top">
                <form id="loginform" class="w3-panel w3-card-4 w3-display-middle" action="" method="post">
                    <h2>Accedi</h2>
                    <hr>
                    <p><input class="w3-input" type="text" placeholder="Username" name="username" value="<?php echo (isset($_POST['username']) ? $_POST['username'] : "");?>"></p>
                    <p><input class="w3-input" type="password" placeholder="Password" name="password"></p>
                    <p><button class="w3-btn w3-black">Accedi</button></p>
                </form>
                <?php
                if (isset($errorlogin)) {
                    echo "<div id=\"alert\" class=\"w3-panel w3-red w3-display-container w3-display-middle \">
						<span onclick=\"this.parentElement.style.display='none'\" class=\"w3-button w3-red w3-large w3-display-topright\">&times;</span>
						<h3><center>Credenziali non valide</center></h3>
					</div>";
                }
                ?>
            </div>
        </div>
    </body>
</html>
