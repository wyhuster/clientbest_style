<?php
require_once('./inc/mysql.inc.php');

$dbconn = new CMysql(DB_HOST, DB_USER, DB_PASS, DB_NAME);

$szQuery="select * from task_20101114 where id<=10";
$q = $dbconn->Query($szQuery);

$num = $dbconn->GetFieldsNum($q);

echo $num;


?>
