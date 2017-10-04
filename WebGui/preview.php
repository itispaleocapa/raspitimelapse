<?php
include("config.php");
$config = parse_ini_file("config.ini");
$stop = 0;
while ($stop==0) {
	$config = parse_ini_file("config.ini");
	if ($config['state']==1 AND ($config['stop']>time() OR $config['stop']==0)) {
		header('Content-Type: image/jpeg');
		readfile($config['lastphoto']);
		$stop = 1;
	}
	else {
		$path = $basepath."shots/tmp/";
		$file =  "tmp".substr(time(),-1).".jpg";
		$command = escapeshellcmd("raspistill -t 1 -vf -hf -n -w 853 -h 480 -o " . $path . $file);
		$output = shell_exec($command);
		if (file_exists($path . $file)) {
			$stop = 1;
		}
		header('Content-Type: image/jpeg');
		readfile($path . $file);
	}	
}
?>