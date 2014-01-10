<?php
	error_reporting(E_ALL);
	date_default_timezone_set("Asia/Chongqing");
	require_once('/home/work/renm/apache/apache2/htdocs/clientbest/web/config.php');
	
	$base_path = "/home/work/renm/apache/apache2/htdocs/clientbest";
	
	$id = $_GET["id"];
	if(!isset($id)){
		echo "no history id!!";
		exit(1);
	}
	
	$report_path = $base_path."/reports/".$id."_report.html";
	if(file_exists($report_path)){
		//show the report
		header("Location: /clientbest/reports/".$id."_report.html"); 										 
		exit(1);
	}

	
	$sql = "select history_record.id,history_record.pid,history_record.time,history_record.stop_time,data_playback.type,data_playback.press_server,data_playback.module_server,data_playback.press_args,data_playback.tool_args from history_record,data_playback where history_record.id=".$id." and history_record.data_id=data_playback.id";
	$result = mysql_query($sql,$db);
	if(!$result){
		echo $sql."\nquery mysql failed!";
		exit(1);
	}
	$row = mysql_fetch_array($result);
    if(count($row) == 0){
        echo "no data in database!";
        exit(1);
    }
	if($row['stop_time'] == "0000-00-00 00:00:00"){
		echo "javascript:alert(\"测试正在运行!\");";
		exit(1);
	}

	$press_server = $row['press_server'];
	$module_server = $row['module_server'];
	if(!isset($module_server)){
		$module_server= $_GET["module_server"];
	}
	$module_server = trim($module_server);
	echo $module_server."---";
	if(!isset($module_server)){
		echo "请输入被测服务运行的主机名host:<br/>";
		echo "<form action="." method='get'>";
		echo "<input type='text' name='module_server' size='40'><br/>";
		echo "<input type='submit' value='提交' />";
		echo "</form>";
		exit(1);
	}
	$pid = $row['pid'];
	$start = $row['time'];
	$end = $row['stop_time'];
	
	$req_para = json_decode($row['tool_args'],true);
	$url = $req_para['tool_args']['url'];
	$http_type = $req_para['tool_args']['type'];
	$config_file = $req_para['config_filedir'];
	
	$jieti_para = json_decode($row['press_args'],true);
	$qps_start = intval($jieti_para['qps_start']);
	$qps_end = intval($jieti_para['qps_end']);
	$qps_interval = intval($jieti_para['qps_interval']);
	$time_interval = intval($jieti_para['time_interval']);
	
	ob_start();
	
	echo "<html><head><title>Report</title></head><body>";
	
	echo "<h2 style=\"text-align:center\">测试报告(id:".$id.")</h2>";
	echo "<h3>(1)测试部署参数:</h3>";
	echo "被测服务所在主机:".$module_server."</br>";
	echo "压力运行服务器: ".$press_server."</br>";
	echo "Pid: ".$pid."<br/>";
	echo "测试时间: ".$start."--".$end."<br/>";
	
	echo "<strong>请求参数:</strong><br/>";
	echo "请求Url: ".$url."<br/>";
	echo "Http类型: ".$http_type."<br/>";
	
	$post_data = $config_file."/data";
	$cookie = $config_file."/cookie";
	echo $post_data."<br/>";
	if(file_exists($post_data)){
		echo "Post data: ".file_get_contents($post_data)."<br/>";
	}
	if(file_exists($cookie)){
		echo "Cookie: ".file_get_contents($post_data)."<br/>";
	}

	echo "<strong>压力参数:</strong><br/>";
	echo "开始qps: ".strval($qps_start)."&nbsp;&nbsp;&nbsp;qps间隔: ".strval($qps_interval)."&nbsp;&nbsp;&nbsp;结束qps: ".strval($qps_end)."<br/>";
	echo "每qps运行时间: ".strval($time_interval)."min&nbsp;&nbsp;&nbsp;间隔时间: 1min<br/>";

	
	echo "<br/><br/>";
	echo "<h3>(2)测试结论:</h3>";
	
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

	$array_qps = array();
	$array_qps_time = array();
	$array_qps_rps = array();
	$array_qps_rt = array();
	$array_qps_cpu = array();
	$array_qps_mem = array();
	$array_qps_load = array();
	$array_qps_io = array();
	
	$no = 0;
	$qps = $qps_start;
	while($qps <= $qps_end){
		array_push($array_qps,$qps);
		
		$time_del_1 = " +".$no*($time_interval + 1)." min +15 second";
    	$temp_ocean_time_begin = strtotime($start.$time_del_1);
    	$ocean_time_begin = date('YmdHis',$temp_ocean_time_begin);

		
		$time_del_1 = " +".(($no + 1)*$time_interval + $no)." min -15 second";
    	$temp_ocean_time_end = strtotime($start.$time_del_1);
    	$ocean_time_end = date('YmdHis',$temp_ocean_time_end);
	
		$array_qps_time[$qps] = array($ocean_time_begin,$ocean_time_end);
		
		$no = $no + 1;
		$qps = $qps + $qps_interval;
	}


	foreach($array_qps as $qps){
		$rps_rt = get_rps_and_rt_from_log($qps);
		$array_qps_rps[$qps] = $rps_rt[0];
		$array_qps_rt[$qps] = $rps_rt[1];
		
		$item_size = get_ocean_data($qps);	
		$array_qps_cpu[$qps] = $item_size["cpu"]; 
		$array_qps_mem[$qps] = $item_size["mem"]; 
		$array_qps_load[$qps] = $item_size["load"]; 
		$array_qps_io[$qps] = $item_size["io"]; 
	}
	//print_r($array_qps_cpu);
	
	echo "<table border>";
	echo "<thead><tr><th rowspan=2>qps</th><th rowspan=2>rps</th><th rowspan=2>response time(ms)</th><th colspan=3>cpu idle(%)</th>
		 <th colspan=3>mem used(%)</th><th colspan=3>load</th><th colspan=3>io wait(ms)</th></tr>";
	echo "<tr><th>max</th><th>avg</th><th>min</th><th>max</th><th>avg</th><th>min</th><th>max</th><th>avg</th><th>min</th><th>max</th>
		 <th>avg</th><th>min</th></tr></thead>";
	echo "<tbody>";
	foreach($array_qps as $qps){
		echo "<tr><td>".$qps."</td>";
		echo "<td>".$array_qps_rps[$qps]."</td>";
		echo "<td>".$array_qps_rt[$qps]."</td>";
		echo "<td>".$array_qps_cpu[$qps]["max"]."</td>";
		echo "<td>".$array_qps_cpu[$qps]["avg"]."</td>";
		echo "<td>".$array_qps_cpu[$qps]["min"]."</td>";
		echo "<td>".$array_qps_mem[$qps]["max"]."</td>";
		echo "<td>".$array_qps_mem[$qps]["avg"]."</td>";
		echo "<td>".$array_qps_mem[$qps]["min"]."</td>";
		echo "<td>".$array_qps_load[$qps]["max"]."</td>";
		echo "<td>".$array_qps_load[$qps]["avg"]."</td>";
		echo "<td>".$array_qps_load[$qps]["min"]."</td>";
		echo "<td>".$array_qps_io[$qps]["max"]."</td>";
		echo "<td>".$array_qps_io[$qps]["avg"]."</td>";
		echo "<td>".$array_qps_io[$qps]["min"]."</td></tr>";
	}
	echo "</tbody></table></body></html>";

	$temp_html_content = ob_get_contents();
	ob_end_clean();
	
	//generate the report
	$temp_html_content;
	if(($TxtRes=fopen($report_path,"w+")) === FALSE){
		echo("create report html ".$TxtFileName." fail");   	 
		exit(1);
				 
	}		 
	//echo ("crteat report xml".$TxtFileName."success！</br>");
				 
	if(!fwrite ($TxtRes,$temp_html_content)){
		echo ("write html to ".$TxtFileName." fail:\n ".$StrConents);
		fclose($TxtRes);
		exit(1);       
	}
	
    header("Location: /clientbest/reports/".$id."_report.html"); 										 
		

function get_rps_and_rt_from_log($qps){

	$file = get_log_files($qps);
	if(!isset($file)){
		return array("null","null");
	}
    $no_rps = array();
    $no_rt = array();
    $i = 1; 
    while($i<=10){
        $log = exec("tac ".$file." |sed -n ".$i."p");
		$temp = explode(' ',$log);
		$rps_temp = $temp[count($temp)-4];
		$rps = substr($rps_temp,0,-1);
		$rt = $temp[count($temp)-1]; 
		$no_rps[$i] = $rps; 
		$no_rt[$i] = $rt;
	
		$i = $i+1; 
	}       
	
	asort($no_rps,SORT_NUMERIC);
	$pos_array = array_keys($no_rps);
	$pos = $pos_array[5];
	
	return array($no_rps[$pos], $no_rt[$pos]);

}
function get_log_files($qps){
	global $base_path;
	global $id;

	$file_path = $base_path."/logs/".$id."_curlpress_log/";
    if(!is_dir($file_path)){
        return;
    }
    $handle=opendir($file_path);
    while($file=readdir($handle))
    {
		$qps_num = "qps".$qps;
		if(substr_count($file,$qps_num)!=0)
		{
			return $file_path.$file;
		}
	}
	closedir($handle);
	return;
}

function get_ocean_data($qps){
	global $array_qps_time;
	global $module_server;
	$starttime = $array_qps_time[$qps][0];
	$endtime = $array_qps_time[$qps][1];
	
	$query_url = "http://ocean.baidu.com/realtime/list/?beginTime=".$starttime."&endTime=".$endtime."&host=".$module_server."&monItems=CPU_IDLE,MEM_URATE,SERVER_LOADAVG1,IO_AVGWAIT";
	
	$xml = simplexml_load_file($query_url);
	$max = $xml->maxValue;
	$avg = $xml->averageValue;
	$min = $xml->minValue;
	
	//echo($max);
	//echo "\n";
	//$max_array = explode(' ',trim($max));
	$max_array=preg_split('/[\s,;]+/',$max);
	$avg_array=preg_split('/[\s,;]+/',$avg);
	$min_array=preg_split('/[\s,;]+/',$min);
	//print_r($max_array);
	//echo "\n";
	//$avg_array = explode(' ',$avg);
	//$min_array = explode(' ',$min);
	$temp_array["cpu"]["max"] = $max_array[0];
	$temp_array["cpu"]["avg"] = $avg_array[0];
	$temp_array["cpu"]["min"] = $min_array[0];
	$temp_array["mem"]["max"] = $max_array[1];
	$temp_array["mem"]["avg"] = $avg_array[1];
	$temp_array["mem"]["min"] = $min_array[1];
	$temp_array["load"]["max"] = $max_array[2];
	$temp_array["load"]["avg"] = $avg_array[2];
	$temp_array["load"]["min"] = $min_array[2];
	$temp_array["io"]["max"] = $max_array[3];
	$temp_array["io"]["avg"] = $avg_array[3];
	$temp_array["io"]["min"] = $min_array[3];
	//print_r($temp_array);
	//echo "\n";
	return $temp_array;
}
?>
