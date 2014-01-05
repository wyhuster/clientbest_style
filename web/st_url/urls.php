<?php

	$url = $_GET['url'];
	$params = $_GET['params'];
	$array = array("http://www.baidu.com/?a=1", "http://www.baidu.com/?b=1", "http://www.baidu.com/?a=1&b=1");    
	echo json_encode($array)
	
?>
