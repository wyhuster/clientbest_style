<?php
	require_once('/home/work/renm/apache/apache2/htdocs/clientbest/web/config.php');
	$pid = $argv[1];
	$press_server = $argv[2];
	$data_id = $argv[3];
	$history_id = $argv[4];
	
	echo "--------------------------------------------------------------------------------\n";
	echo "press_server:".$press_server."  pid:".$pid."  history_id:".$history_id."  data_id:".$data_id."\n";
	if(!$pid || !$press_server){
		stopProcess($press_server);
	}
	else{
	 while(true){
		sleep(2);
		$curdir = "/home/work/renm/apache/apache2/htdocs/clientbest/tools/";	
		$cmd = "sh ".$curdir."is_press_running.sh ".$pid." ".$press_server;
		$result = exec($cmd);
		//$fp = fopen("/home/work/renm/apache/apache2/htdocs/clientbest/web/tools/stop.log","a");
		//fwrite($fp,"$result\n");
		//fclose($fp);
		date_default_timezone_set('Asia/Chongqing');
		$date = date('Y-m-d H:i:s');
		echo($date."   ".$result."\n"); 
		if($result < 1){
			//has stop
			stopProcess($press_server,$data_id,$history_id);
			break;
		}
	 }
	}


	function stopProcess($server,$data_id,$history_id){
		global $db;
		//get the current history_id and data_id
		//$sql = "select id,data_id from history_record order by id desc limit 1";
		//$result = mysql_query($sql,$db);
		//$row = mysql_fetch_array($result);
		//$id = $row["id"];
		//$data_id = $row["data_id"];
		//mysql_free_result($result);

		//update the data running
		$data_sql = "update data_playback set running = 0 where id = $data_id";	
		mysql_query($data_sql,$db);
		
		//update the history stop time
		$history_sql = "update history_record set stop_time = NOW() where id = $history_id";	
		mysql_query($history_sql,$db);

		//copy the logs
		if($server){
			$shell = "scp -r $server:/home/work/clientbest/logs/${history_id}_curlpress_log/ /home/work/renm/apache/apache2/htdocs/clientbest/logs/";
			exec($shell);
		}
	}
?>
