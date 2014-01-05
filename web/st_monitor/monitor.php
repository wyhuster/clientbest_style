<?php
	require_once('/home/work/renm/apache/apache2/htdocs/clientbest/web/common.php');
?>

<html><head>
<title>测试监控</title>
<meta http-equiv=Content-Type content="text/html; charset=utf-8">
<link href="./../css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="./async_log.js"></script>
</head>
<body bgcolor="#FAFCFF">
<div>
<h3 align="left">测试监控</h3>
<hr/>
</div>

<?php 
	$model  =NULL;
	if(isset($_GET['id']) && $_GET['id'] != NULL){ 
		$id = $_GET['id']; 
		$model = AbstractPressModel::reload($id);
	}

	if($model != NULL){
		if($model->isRunning())
			 echo "<p align = left style='font-family:Arial;font-size:20px;padding-top:15px; font-weight:bolder;' >注意，当前监控可能不是由您部署的！<p>";	
		else{
			
			echo "<p align = center style='font-family:Arial;font-size:20px;padding-top:15px; font-weight:bolder;' >您没有开始测试或者测试已经结束，不需要监控！！<p>";
			return;
		}
	}else{
		if(isset($id)){
			echo "id参数不正确！！！";
			return;
		}	
		$model = running_model();
	}
	if(!$model){
		echo "<p align = center style='font-family:Arial;font-size:20px;padding-top:15px; font-weight:bolder;' >您没有开始测试或者测试已经结束，不需要监控！！<p>";
		return;
	}
	$model->show();
	
	
	//show curlpress log
	if($model->getToolName()=="curlpress"){
		echo "<hr>";
		echo "curlpress log: <button id='btn_pause_log' type='button' onclick='setPause()'>暂停</button>";
		echo "<textarea id='curlpress_log' style='width:100%;height:30%;' readonly='readonly'></textarea>";
		echo '<script type="text/javascript">';
		echo 'showCurlpressLog("'.$model->getPressServer().'")';
		echo '</script>';
	}

	echo "<hr>";
	
	if(isset($id) && $id != NULL)
        $param = "?id=$id";
    else        
        $param = "";
    echo "<input type=submit value='刷新' onclick='location.href=\"/clientbest/web/st_monitor/monitor.php".$param."\"'><br>";
	
	$model->monitor();
?>
</body>

</html>

