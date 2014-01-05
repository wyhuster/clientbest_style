<?php
header("Content-Type:text/html;charset=utf-8");
$mysql_server_name="10.81.15.41";
$mysql_username="work";
$mysql_password="passwd";
$mysql_database="stability_platform";

 $db=mysql_connect($mysql_server_name,$mysql_username,$mysql_password)
 or die("could not connect mysql");

mysql_query("set names UTF-8");

 mysql_select_db($mysql_database,$db)
 or die("could not open database");
?>
