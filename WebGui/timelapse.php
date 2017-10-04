<?php
include("functions.php");
while (1==1) {
	$config = parse_ini_file("config.ini");
	if ($config['state']==1 AND ($config['stop']>time() OR $config['stop']==0)) {
		while ($config['state']==1) {
			$time1 = time();
			$path = $config['path'];
			$path = urldecode($path);	
			$file = date("YmdHis") . ".jpg";
			
			$command = escapeshellcmd("raspistill -t 1 -vf -hf -n -w 1920 -h 1080 -o " . $path . $file);
			$output = shell_exec($command);
			
			$lastphoto = $path . $file;
			$config['lastphoto'] = $lastphoto;
			file_put_contents("config.ini", arr2ini($config));
			
			$time2 = time();
			if ($config['delay']-($time2-$time1)>0) {
				sleep($config['delay']-($time2-$time1));
			}			
			$config = parse_ini_file("config.ini");
			if ($config['stop']<time() AND $config['stop']!=0) {
				$config['state'] = 0;
			}
		}
	}
	sleep(5);
}
