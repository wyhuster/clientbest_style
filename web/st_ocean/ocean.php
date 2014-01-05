<?php
	 require_once('/home/work/renm/apache/apache2/htdocs/clientbest/web/config.php');
?>
<html><head>
<title>Ocean监控</title>
<meta http-equiv=Content-Type content="text/html; charset=utf-8">
<link href="./../css/style.css" rel="stylesheet" type="text/css" />
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
		echo "<font size='2'><strong>压力参数</strong></font><br/>";
		echo "url: ".$json_args["tool_args"]["url"]."<br/>";
		echo "press server: ".$press_server."</br>";
		echo "start time: ".$starttime."<br/>";
		if($stoptime == "0000-00-00 00:00:00"){
			echo "<font color='red'>正在运行...</font>";
		}else{
			echo "stop time: ".$stoptime;
		}
		echo "<br/><br/><hr/>";

		mysql_free_result($result);
		
		preg_match_all('/\d/S',$starttime, $matches);
		$start = implode('',$matches[0]);
		
		echo "
		<font size='2'><strong>资源监控</strong></font><br/>
		<table>
		<tr>
		<td>*主机名host：</td>
		<td><input type='text' id='hostname' placeholder='cp01-testing-bdcm06.cp01.baidu.com' size='50'></td>
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
		<input type='text' id='end_date' placeholder='yyMMddHHmmss' value='".$stop."'>
		</td>
		</tr>
		<tr>";
		
	}else{
		echo "
		<font size='2'><strong>资源监控</strong></font><br/>
		<table>
		<tr>
		<td>*主机名host：</td>
		<td><input type='text' id='hostname' placeholder='cp01-testing-bdcm06.cp01.baidu.com' size='50'></td>
		</tr>
		<tr>
		<td>*查询时间：</td>
		<td><input type='text' id='start_date' placeholder='yyyyMMddHHmmss'>
		--
		<input type='text' id='end_date' placeholder='yyMMddHHmmss'>
		</td>
		</tr>
		<tr>";
	}
?>
    <td>*监控项选择：</td>
</tr>
<tr>
	<td><input type="checkbox" checked="checked" id="cpu_idle" value="CPU_IDLE">CPU闲置时间</td>
	<td><input type="checkbox" id="mem_urate" value="MEM_URATE">物理内存使用率</td>
</tr>
<tr>
    <td><input type="checkbox" id="load_avg1" value="SERVER_LOADAVG1">1分钟平均负载</td>
    <td><input type="checkbox" id="io_avg_wait" value="IO_AVGWAIT">平均I/O等待时间</td>
</tr> 
<tr>
<td><br/></td>
</tr>
<tr>
	<td><button onclick="checkArgs()"><font size="3px">查询并显示监控图像</font></button></td>
</tr>		 
</table>
<br/>
<div><font size="1px" color="blue">*点击访问<a href='http://ocean.baidu.com/'>Ocean开发测试云</a>查询更多资源监控.</font></div>
</body>
</html>

<script type="text/javascript">
	function getTextboxValue(id){
		var text = document.getElementById(id).value;
		var textValue = text.replace(/(^\s*)|(\s*$)/g, "");
		if(textValue == null || textValue == "") {  
			return "";  
		}
		return textValue;
	}

	function getCheckedItems(){
		var array = new	Array();
		var c1 = document.getElementById("cpu_idle");
		if(c1.checked){
			array.push(c1.value);
		}
		var c2 = document.getElementById("mem_urate");
		if(c2.checked){
			array.push(c2.value);
		}
		var c3 = document.getElementById("load_avg1");
		if(c3.checked){
			array.push(c3.value);
		}
		var c4 = document.getElementById("io_avg_wait");
		if(c4.checked){
			array.push(c4.value);
		}
		if(array.length == 0){
			return "";
		}else{
			return array.join(",");
		}
	}
	
	function checkArgs(){
		var host = getTextboxValue("hostname");
		var starttime = getTextboxValue("start_date");
		var endtime = getTextboxValue("end_date");
		
		if(host == ""){
			alert("host不能为空!");
			return;
		}
		if(starttime == ""){
			alert("开始时间不能为空!");
			return;
		}
		if(endtime == ""){
			alert("结束时间不能为空!");
			return;
		}
		if((starttime-0)>(endtime-0)){
			alert("开始时间不能大于结束时间");
			return;
		}
		var items = getCheckedItems();
		if(items == ""){
			alert("请选择监控项!");
			return;
		}
		
		var url = "http://ocean.baidu.com/realtime/graph/?pn=3.1&begin=".concat(starttime).concat("&end=").concat(endtime).concat("&host=").concat(host).concat("&items=").concat(items);
		window.location.href = url;
	}
</script>
