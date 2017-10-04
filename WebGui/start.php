<?php
session_start();
include("config.php");
include("functions.php");
$path = $basepath."shots/";
if (!isLogged()) {
    header("location: login.php");
	die;
}
if (isset($_POST) AND isset($_POST['nometimelapse']) AND isset($_POST['delaytimelapse']) AND isset($_POST['stoptimelapse'])) {
    $config = parse_ini_file("config.ini");
    if ($config['state']==1 AND $config['stop']>time() AND $config['stop']!=0) {
        $error = "C'è già un timelapse attivo";
    }
    elseif ($_POST['delaytimelapse']<2) {
        $error = "Delay minimo: 2 secondi";
    }
    else {
        $config['state'] = 1;
        $config['nome'] = '"'.$_POST['nometimelapse'].'"';
        $_POST['nometimelapse'] = addslashes($_POST['nometimelapse']);
        $config['delay'] = $_POST['delaytimelapse'];
        $config['start'] = time();
        $config['stop'] = time()+($_POST['stoptimelapse']*60);
        $config['path'] = urlencode($path.date("YmdHis-").$_POST['nometimelapse']."/");
        mkdir($path.date("YmdHis-").$_POST['nometimelapse']);
        file_put_contents("config.ini", arr2ini($config));
        header("location: index.php");
    	die;
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
        .w3-card-4 {
            margin: 0 auto;
        }
        #alert {
            width: 450px;
            height: 60px;
        }
        #form {
            width: 50%;
        }
        @media screen
          and (min-width: 100px)
          and (max-width: 667px) {
              #form {
                  width: 90%;
                  margin-top: 80px;
              }
              #alert {
                  width: 220px;
                  height: 100px;
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
                <form id="form" class="w3-panel w3-card-4" action="" method="post">
                    <h2>Nuovo timelapse</h2>
                    <hr>
                    <p><input class="w3-input" type="text" placeholder="Nome timelapse" name="nometimelapse" value="<?php echo (isset($_POST['nometimelapse']) ? $_POST['nometimelapse'] : "");?>" required></p>
                    <p><input class="w3-input" type="number" placeholder="Scatta ogni x secondi" name="delaytimelapse" min=2 value="<?php echo (isset($_POST['delaytimelapse']) ? $_POST['delaytimelapse'] : "");?>" required></p>
                    <p><input class="w3-input" type="number" placeholder="Termina dopo x minuti (0 per stop manuale)" min=0 name="stoptimelapse" value="<?php echo (isset($_POST['stoptimelapse']) ? $_POST['stoptimelapse'] : "");?>" required></p>
                    <p><button class="w3-btn w3-black">Crea</button></p>
                </form>
                <?php
                if (isset($error)) {
                    echo "<div id=\"alert\" class=\"w3-panel w3-red w3-display-container w3-display-middle \">
						<span onclick=\"this.parentElement.style.display='none'\" class=\"w3-button w3-red w3-large w3-display-topright\">&times;</span>
						<h3><center>$error</center></h3>
					</div>";
                }
                ?>
                <p><a href="index.php">indietro</a></p>
            </div>
        </div>
    </body>
</html>
