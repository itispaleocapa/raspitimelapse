<?php
function isLogged() {
    if (!isset($_SESSION) OR !isset($_SESSION['login']) OR $_SESSION['login']!=1) {
    	return false;
    }
    else {
        return true;
    }
}

function arr2ini($array) {
    $ini = "";
    foreach ($array AS $thisK => $thisV) {
        $ini .= $thisK." = ".$thisV.PHP_EOL;
    }
    return $ini;
}
?>
