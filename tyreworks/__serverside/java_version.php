<?php
        // Show whoami
        $output = shell_exec("whoami");
        echo "<strong>WHOAMI</strong>";
        echo "<hr/>";
        echo "$output<br/><br/><br/><br/>";
        $output = shell_exec("echo 'I am just an echo from shell_exec()'");
        echo $output . "<br />";
        // Show The Java Version Before Setting Environmental Variable
        $output = shell_exec("java -version 2>&1");
        echo "<strong>Java Version Before Setting Environmental Variable</strong>";
        echo "<hr/>";
        echo "$output<br/><br/><br/><br/>";
 
        // Set Enviromental Variable
        $JAVA_HOME = "/usr/local/jdk1.5.0_15";
        $PATH = "$JAVA_HOME/bin:/usr/local/bin:/usr/bin:/bin";
        putenv("JAVA_HOME=$JAVA_HOME");
        putenv("PATH=$PATH");
 
        // Show The Java Version After Setting Environmental Variable
        $output = shell_exec("java -version 2>&1");
        echo "<strong>Java Version After Setting Environmental Variable</strong>";
        echo "<hr/>";
        echo $output;
?>