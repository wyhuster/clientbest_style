﻿<?php
	error_reporting(E_ALL);
	require_once("/home/work/renm/apache/apache2/htdocs/clientbest/web/head.php");
	require_once("/home/work/renm/apache/apache2/htdocs/clientbest/web/st_data/side_menu.php");
?>

<div id="content">
<div id="content-header">
  <div id="breadcrumb"> 
      <a href="../index.php" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> 
      <a href="data_show.php" class="tip_bottom">数据回放</a> 
	  <a href="" class="current">配置文件</a> 
  </div>  
</div>
<div class="container-fluid">

<?php

	$conf_file_path = $_GET['filepath'];
	if(!isset($conf_file_path) || $conf_file_path == NULL ){
		echo "请输入参数 conf_file_path.\n";
	}
	else{
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
	}
?>
</div>
</div>

<?php
require_once("/home/work/renm/apache/apache2/htdocs/clientbest/web/foot.php");
?>
