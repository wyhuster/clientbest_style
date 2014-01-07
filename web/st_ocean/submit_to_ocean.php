<?php
	$url = $_GET["url"];
	//echo $url;
	$response = file_get_contents($url);
	echo $response;
?>
