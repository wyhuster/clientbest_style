<?php
	$server = $_GET["server"];
	$shell = "ssh work@".$server." grep -a consume /home/work/clientbest/tools/curlpress.log | tail -1";
	$test=exec($shell);
	echo $test."\n";
?>
