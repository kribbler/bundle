<?php 


$x = system('java -jar /home/tyreworksco/public_html/__serverside/java/MidasWebsiteJavaConsole.jar'); 
mail("daniel.oraca@gmail.com", 'cron test - new', date('Y-m-d h:i:s') . var_dump($x));
?>