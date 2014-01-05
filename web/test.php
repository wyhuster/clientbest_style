<?php
	/**
$conf_file_path = $_GET['filepath'];
if(!isset($conf_file_path) || $conf_file_path == NULL ){
	echo "请输入参数 conf_file_path.\n";
	return;
}
*/
//$conf_content = file_get_contents($conf_file_path);
//$conf_content = file_get_contents("10.94.49.33:/home/work/clientbest/logs/131_curlpress_log/20140102_102545_qps30_curlpress.log");
//$content_arr = explode("\n", $conf_content);
//foreach($content_arr as $row)
//{
//	echo htmlspecialchars($row)."<br/>";
//}
$shell = "scp -r 10.94.49.33:/home/work/clientbest/logs/131_curlpress_log/ /home/work/renm/apache/apache2/htdocs/clientbest/logs/";
exec($shell);
$conf_file_path = "/home/work/renm/apache/apache2/htdocs/clientbest/logs/131_curlpress_log/20140102_102545_qps30_curlpress.log";
$conf_content = file_get_contents($conf_file_path);
$content_arr = explode("\n", $conf_content);
foreach($content_arr as $row)
{
	echo htmlspecialchars($row)."<br/>";
}
while(true){
	sleep(100);
}
?>
