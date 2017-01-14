<?php

/*command to run is
* /usr/bin/php /home/sites/tyreworks.co.uk/public_html/__serverside/run_java.php
*/

mail("daniel.oraca@gmail.com", 'cron run_java.php test', date('Y-m-d h:i:s'));

//echo 'x';
ini_set("max_execution_time",0);
ini_set('memory_limit', '-1');
error_reporting(E_ALL);
ini_set("display_errors", 1);

$dir = getcwd();
/*
if(function_exists('shell_exec')) {
    echo "exec is enabled"; //die();
} else {
	echo 'exec not enabled'; die();
}*/

//echo shell_exec('date');
echo '<br />';
echo 'java -jar "' . $dir . '/java/MidasWebsiteJavaConsole.jar"';
echo '<br />';

exec( 'java -jar "' . $dir . '/java/MidasWebsiteJavaConsole.jar"', $out );
echo '<br />';
echo "<pre>"; var_dump($out); echo "</pre>";

//new way
//echo "<br />New Way:</br />";
//$x = system('java -jar /home/tyreworksco/public_html/__serverside/java/MidasWebsiteJavaConsole.jar');
//echo "<pre>";var_dump($x); echo "</pre>";