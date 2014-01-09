<?php
	error_reporting(E_ALL);
?>

<html><head>
<title>配置文件展示</title>
<meta http-equiv=Content-Type content="text/html; charset=utf-8">
<meta http-equiv=html content=no-cache>
<link href="./../css/style.css" rel="stylesheet" type="text/css" />
<!--<script type="text/javascript" src="./../js/conf.js"></script>-->
</head>

<body bgcolor="#FAFCFF" >
<div>
<h3 align="left">文件内容</h3>
<hr/>
</div>

<?php

	$conf_file_path = $_GET['filepath'];
	if(!isset($conf_file_path) || $conf_file_path == NULL ){
		echo "请输入参数 conf_file_path.\n";
		return;
	}
	echo "<h4>$conf_file_path</h4><br/>";
	/**
	$conf_content = file_get_contents($conf_file_path);
	$content_arr = explode("\n", $conf_content);
	foreach($content_arr as $row)
	{
		echo htmlspecialchars($row)."<br/>";
	}
	*/

	$file_handle = fopen($conf_file_path, "r");
	while (!feof($file_handle)) {
   		$line = fgets($file_handle);
   		echo htmlspecialchars($line)."<br/>";
	}
	fclose($file_handle);
?>
</body>
</html>
