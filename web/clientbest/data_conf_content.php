<?php
	error_reporting(E_ALL);
	#require_once('../inc/commen.php');
	require_once("/home/work/renm/apache/apache2/htdocs/clientbest/web/tools/factory.php");
	#$timeNow = time();

?>

<html><head>
<title>配置文件展示</title>
<meta http-equiv=Content-Type content="text/html; charset=utf-8">
<meta http-equiv=html content=no-cache>
<link href="./../css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="./../js/conf.js"></script>
</head>

<body bgcolor="#FAFCFF" >
<div>
<h3 align="left">配置文件</h3>
<hr/>
</div>
<br/>
<br/>

<?php

	$ret_result = true;
	$conf_file_path = $_GET['filepath'];
	if(!isset($conf_file_path) || $conf_file_path == NULL ){
		echo "请输入参数 conf_file_path.\n";
		return;
	}
	$conf_content = file_get_contents($conf_file_path);
	$content_arr = explode("\n", $conf_content);
	foreach($content_arr as $row)
	{
		echo htmlspecialchars($row)."<br/>";
	}	
?>
</body>
</html>
