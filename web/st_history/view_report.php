<?php
	error_reporting(E_ALL);
	require_once('/home/work/renm/apache/apache2/htdocs/clientbest/web/config.php');
	
	
	$id = $_GET["id"];
	if(!isset($id)){
		echo "no history id!!";
		return;
	}
	
	$report_path = "/home/work/renm/apache/apache2/htdocs/clientbest/reports/".$id."_report.html";
	if(file_exists($report_path)){
		//show the report
		
		return;
	}

	
	$sql = "select history_record.id,history_record.pid,history_record.time,history_record.stop_time,data_playback.type,data_playback.press_server,data_playback.press_args,data_playback.tool_args from history_record,data_playback where history_record.id=".$id." and history_record.data_id=data_playback.id";
	$result = mysql_query($sql,$db);
	if(!$result){
		echo $sql."\nquery mysql failed!";
		return;
	}
	$row = mysql_fetch_array($result);
    if(count($row) == 0){
        echo "no data in database!";
        return;
    }
	if($row['stop_time'] == "0000-00-00 00:00:00"){
		echo "javascript:alert(\"测试正在运行!\");";
		return;
	}

	
	ob_start();

	$press_server = $row['press_server'];
	$pid = $row['pid'];
	$start = $row['time'];
	$end = $row['stop_time'];
	
	$req_para = json_decode($row['tool_args'],true);
	$url = $req_para['tool_args']['url'];
	$http_type = $req_para['tool_args']['type'];
	$config_file = $req_para['config_filedir'];
	
	$jieti_para = json_decode($row['press_args'],true);
	
	echo "<h3>测试部署参数:</h3><br/>";
	echo "压力运行服务器: ".$req_para + "&nbsp;&nbsp;&nbsp;";
	echo "Pid: ".$pid."<br/>";
	echo "测试时间: ".$start."--".$end."<br/>";
	
	echo "<strong>请求参数:</strong><br/>";
	echo "请求Url: ".$url."<br/>";
	echo "Http类型: ".$http_type."<br/>";
	
	$post_data = $config_file."/data";
	$cookie = $config_file."/cookie";
	if(file_exists($post_data)){
		echo "Post data: ".$file_get_contents($post_data)."<br/>";
	}
	if(file_exists($cookie)){
		echo "Cookie: ".$file_get_contents($post_data)."<br/>";
	}

	echo "<strong>压力参数:</strong><br/>";
	echo "开始qps: ".$jieti_para['qps_start']."&nbsp;&nbsp;&nbsp;qps间隔: ".$jieti_para['qps_interval']."&nbsp;&nbsp;&nbsp;结束qps: ".$jieti_para['qps_end']."<br/>";
	echo "每qps运行时间: ".$jieti_para['time_interval']."min&nbsp;&nbsp;&nbsp;间隔时间: 1min<br/>";

	
	echo "<br/><br/>";
	echo "<h3>测试结论:</h3><br/>";
	
	/**
	array qps->rps
	         ->rt
			 ->cpu idle->min 
					   ->avg
					   ->max
			 ->memory  ->min 
					   ->avg
					   ->max
			 ->load    ->min 
					   ->avg
					   ->max
			 ->io      ->min 
					   ->avg
					   ->max

	
	*/


	
	$temp = ob_get_contents();
	ob_end_clean();


	
	
	//generate the report
	
	//display the press test args
	
?>
