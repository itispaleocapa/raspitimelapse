<?php
session_start();
include("functions.php");
if (!isLogged()) {
    header("location: login.php");
	die;
}
$config = parse_ini_file("config.ini");
if ($config['stop']<time() AND $config['stop']!=0) {
	$config['state'] = 0;
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
		.tilecontainer {
			margin: 0 auto;
			width: 400px;
		}
		.tilebig {
			height: 200px;
			width: 400px;
			border: 4px solid #fff;
			padding: 10px;
		}
		.tilesmall {
			height: 200px;
			width: 200px;
			border: 4px solid #fff;
			padding: 5px;
		}
		.floatl {
			float: left;
		}
		.green {
			background-color: #7CFC00;
		}
		.red {
			background-color: #ff0000;
			color: #fff;
		}
		.clearfix {
			float: none;
			clear: both;
		}
		.statebtn {
			height: 100%;
		}
		.stateinfo {
			float: left;
			font-size: 2.2em;
			text-align: center;
			width: 200px;
		}
		#preview {
			max-height: 480px;
		}
		@media screen
          and (min-width: 100px)
          and (max-width: 340px) {
              .w3-left, .w3-right {
				  width: 100%;
				  text-align: center;
			  }
        }
        </style>
    </head>
    <body>
        <div id="content" style="height:100%">
            <div class="w3-container w3-blue w3-xlarge w3-padding-16">
                <span class="w3-left w3-padding">RaspiTimeLapse</span>
				<span class="w3-right w3-padding"><a href="logout.php" style="font-size: 15px;">Logout</a></span>
            </div>
            <div class="w3-content w3-margin-top">
				<div class="tilecontainer">
					<div class="tilebig <?php echo ($config['state']==0 ? "red" : "green");?>">
						<?php
						if ($config['state']==0) {
							echo "<a href='start.php'><img class='statebtn floatl' src='img/on.png' /></a>";
						}
						else {
							echo "<a href='stop.php' onclick=\"return confirm('Vuoi veramente fermare il timelapse?');\"><img class='statebtn floatl' src='img/off.png' /></a>";
						}
						?>
						<div class="stateinfo">
							Stato:
							<?php
							if ($config['state']==0) {
								echo "OFF";
							}
							elseif ($config['state']==1) {
								echo "ON";
							}
							?>
						</div>
					</div>
					<div class="clearfix"></div>
				</div>

				<div style="text-align:center; margin-top:10px;">
					<p><?php
					if ($config['state']==1) {					
						if ($config['stop']>time()) {
							echo "<br>Sto scattando ogni ".$config['delay']." secondi";
							echo "<br>Stop alle: ".date("d/m/Y H:i:s", $config['stop']);
						}
					}				
					?>
					</p>
					<img id="preview" src="preview.php?" />
				</div>			
            </div>
        </div>
        <script>
			window.onload = function() {
				var image = document.getElementById("preview");

				function updateImage() {
					image.src = image.src.split("?")[0] + "?" + new Date().getTime();
				}

				setInterval(updateImage, 5000);
			}
        </script>
    </body>
</html>
