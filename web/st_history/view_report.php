<?php
	error_reporting(E_ALL);
	require_once('/home/work/renm/apache/apache2/htdocs/clientbest/web/config.php');
	$base_path = "/home/work/renm/apache/apache2/htdocs/clientbest";
	
	$id = $_GET["id"];
	if(!isset($id)){
		echo "no history id!!";
		return;
	}
	
	$report_path = $base_path."/reports/".$id."_report.html";
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
	$qps_start = intval($jieti_para['qps_start']);
	$qps_end = intval($jieti_para['qps_end']);
	$qps_interval = intval($jieti_para['qps_interval']);
	$time_interval = intval($jieti_para['time_interval']);
	
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
	echo "开始qps: ".strval($qps_start)."&nbsp;&nbsp;&nbsp;qps间隔: ".strval($qps_interval)."&nbsp;&nbsp;&nbsp;结束qps: ".strval($qps_end)."<br/>";
	echo "每qps运行时间: ".strval($time_interval)."min&nbsp;&nbsp;&nbsp;间隔时间: 1min<br/>";

	
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

	$array_qps = array();
	$array_qps_time = array();
	date_default_timezone_set("Asia/Chongqing");
	
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

	$array_qps_rps = array();
	$array_qps_rt = array();
	$array_qps_cpu = array();
	$array_qps_mem = array();
	$array_qps_load = array();
	$array_qps_io = array();

	foreach($array_qps as $qps){
		$rps_rt = get_rps_and_rt_from_log($qps);
		$array_qps_rps[$qps] = $rps_rt[0];
		$array_qps_rt[$qps] = $rps_rt[1];
	}
	
	


	
	$temp = ob_get_contents();
	ob_end_clean();


	
	
	//generate the report
	
	//display the press test args
	

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

	$file_path = $base_path"/logs/".$id."_curlpress_log/";
    if(!is_dir($file_path)){
        return;
    }
    $handle=opendir($file_path);
    while($file=readdir($handle))
    {
		$qps_num = "qps".$qps;
		if(substr_count($file,$qps_num);
		{
			return $file_path.$file;
		}
	}
	closedir($handle);
	return;
}

function get_ocean_data($qps){
	global $array_qps_time;
	$starttime = $array_qps_time[$qps][0];
	$endtime = $array_qps_time[$qps][1];
	
	$query_url = "http://ocean.baidu.com/realtime/list/?beginTime=".$starttime."&endTime=".$endtime."&host=cp01-testing-bdcm06.cp01.baidu.com&monItems=CPU_IDLE,MEM_URATE,SERVER_LOADAVG1,IO_AVGWAIT";
	
	$xml = simplexml_load_file($query_url);
	$max = $xml->maxValue;
	$avg = $xml->averageValue;
	$min = $xml->minValue;
}
?>
