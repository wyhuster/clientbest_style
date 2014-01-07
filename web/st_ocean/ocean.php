<?php
	 require_once('/home/work/renm/apache/apache2/htdocs/clientbest/web/config.php');
?>
<html><head>
<title>Ocean监控</title>
<meta http-equiv=Content-Type content="text/html; charset=utf-8">
<link href="./../css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="./ocean.js"></script>
</head>
<body bgcolor="#FAFCFF">
<div>
<h3 align="left">Ocean监控</h3> 
<hr/>
</div>
<?php
	$id = $_GET["id"];
	if(isset($id)){
		$sql = "select history_record.time,history_record.stop_time,data_playback.press_server,data_playback.tool_args from history_record,data_playback where history_record.id=$id and history_record.data_id=data_playback.id";
		$result = mysql_query($sql);
		if(!$result)
        {
            echo $sql."query mysql failed!";
            return;
    	}
		$row = mysql_fetch_array($result);
		if(count($row) == 0){
            echo "no data in database!";
			return;
        }

		$starttime = $row["time"];
		$stoptime = $row["stop_time"];
		$press_server = $row["press_server"];
		$tool_args = $row["tool_args"];

		$json_args = json_decode($tool_args,true);
		echo "<font size='2'><strong>压力参数 id=".$id."</strong></font><br/>";
		echo "url: ".$json_args["tool_args"]["url"]."<br/>";
		echo "press server: ".$press_server."</br>";
		echo "start time: ".$starttime."<br/>";
		if($stoptime == "0000-00-00 00:00:00"){
			echo "<font color='red'>正在运行...</font>";
		}else{
			echo "stop time: ".$stoptime;
		}
		echo "<br/><hr/>";

		mysql_free_result($result);
		
		preg_match_all('/\d/S',$starttime, $matches);
		$start = implode('',$matches[0]);
		
		echo "
		<table>
		<tr>
		<td>*主机名host：</td>
		<td><input type='text' id='hostname' placeholder='cp01-testing-bdcm06.cp01.baidu.com' size='50'></td>
		<td><button onclick='showProOcean()'>进程监控</button></td>
		</tr>
		<tr>
		<td>*查询时间：</td>
		<td><input type='text' id='start_date' placeholder='yyyyMMddHHmmss' value='".$start."'>
		--
		";

		
		if($stoptime == "0000-00-00 00:00:00"){
			$stoptime = date("Y-m-d H:i:s");
		}
		preg_match_all('/\d/S',$stoptime, $matches);
		$stop = implode('',$matches[0]);
		echo "
		<input type='text' id='end_date' placeholder='yyyyMMddHHmmss' value='".$stop."'>
		</td>
		</tr>
		</table>";
		
	}else{
		echo "
		<table>
		<tr>
		<td>*主机名host：</td>
		<td><input type='text' id='hostname' placeholder='cp01-testing-bdcm06.cp01.baidu.com' size='50'></td>
		<td><button onclick='showProOcean()'>进程监控</button></td>
		</tr>
		<tr>
		<td>*查询时间：</td>
		<td><input type='text' id='start_date' placeholder='yyyyMMddHHmmss'>
		--
		<input type='text' id='end_date' placeholder='yyyyMMddHHmmss'>
		</td>
		</tr>
		</table>";
	}
?>
<br/>
<font size='2'><strong>资源监控</strong></font><br/>
<table>
<tr>
    <td>*监控项选择：</td>
</tr>
<tr>
	<td><input type="checkbox" checked="checked" id="cpu_idle" value="CPU_IDLE">CPU闲置时间
	<input type="checkbox" id="mem_urate" value="MEM_URATE">物理内存使用率
    <input type="checkbox" id="load_avg1" value="SERVER_LOADAVG1">1分钟平均负载
    <input type="checkbox" id="io_avg_wait" value="IO_AVGWAIT">平均I/O等待时间</td>
</tr> 
<tr>
	<td><button onclick="checkArgs()"><font size="3px">查询并显示资源图像</font></button></td>
</tr>		 
</table>

<iframe id="pro_frame" name="pro_frame" width=100% height=100% frameborder=0 onload="this.height=pro_frame.document.body.scrollHeight" style="display:none;"></iframe>
<!--
<div id='pro_panel' style="display:none;">
<font size='2'><strong>进程监控  <label id='host_label'></label></strong></font><br/>
</div>
-->
<div><br/><hr/><font size="1px" color="blue">*点击访问<a href='http://ocean.baidu.com/' target='_blank'>Ocean开发测试云</a>查询更多资源监控.</font></div>
</body>
</html>

