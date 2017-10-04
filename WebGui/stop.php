<?php
session_start();
include("functions.php");
if (!isLogged()) {
    header("location: login.php");
	die;
}
$config = parse_ini_file("config.ini");
$config['state'] = 0;
$config['stop'] = 0;
$config['nome'] = '"'.$config['nome'].'"';
file_put_contents("config.ini", arr2ini($config));
header("location: index.php");
die;
?>
