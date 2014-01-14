<?php
	 require_once('/home/work/renm/apache/apache2/htdocs/clientbest/web/config.php');
	 require_once('/home/work/renm/apache/apache2/htdocs/clientbest/web/head.php');
	 require_once('/home/work/renm/apache/apache2/htdocs/clientbest/web/st_ocean/side_menu.php');
?>
<!--main-container-part-->
<div id="content">
<!--breadcrumbs-->
  <div id="content-header">
    <div id="breadcrumb">
    <a href="../index.php" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a>
    <a href="" class="current">ocean监控</a>
    </div>
  </div>
  <!--End-breadcrumbs-->

<div class="container-fluid">
<br/>
<?php
	$id = $_GET["id"];
	if(isset($id)){
		$sql = "select history_record.time,history_record.stop_time,data_playback.module_server,data_playback.press_server,data_playback.tool_args from history_record,data_playback where history_record.id=$id and history_record.data_id=data_playback.id";
		$result = mysql_query($sql);
		if(!$result)
        {
            echo $sql."query mysql failed!";
			echo "</div></div>";
			require_once('/home/work/renm/apache/apache2/htdocs/clientbest/web/foot.php');
            return;
    	}
		$row = mysql_fetch_array($result);
		if(count($row) == 0){
            echo "no data in database!";
			echo "</div></div>";
			require_once('/home/work/renm/apache/apache2/htdocs/clientbest/web/foot.php');
			return;
        }

		$starttime = $row["time"];
		$stoptime = $row["stop_time"];
		$module_server = $row["module_server"];
		$press_server = $row["press_server"];
		$tool_args = $row["tool_args"];

		$json_args = json_decode($tool_args,true);

		echo "<font size='2'><strong>压力参数 id=".$id."</strong></font><br/>";
		echo "<table>";
		echo "<tr><td>url :</td><td>".$json_args["tool_args"]["url"]."</td></tr>";
		echo "<tr><td>service host :&nbsp;&nbsp;</td><td>".$module_server."</td></tr>";
		echo "<tr><td>press server : </td><td>".$press_server."</td></tr>";
		echo "<tr><td>start time :</td><td>".$starttime."</td></tr>";
		if($stoptime == "0000-00-00 00:00:00"){
			echo "<tr><td><font color='red'>正在运行...</font></td></tr>";
		}else{
			echo "<tr><td>stop time :</td><td>".$stoptime."</td></tr>";
		}
		echo "</table><hr/>";

		mysql_free_result($result);
		
		//only keep number for time
		//preg_match_all('/\d/S',$starttime, $matches);
		//$start = implode('',$matches[0]);
		
		echo "
		  <div class='row-fluid'>
		      <div class='span10'>
  		<div class='widget-box'>
        	<div class='widget-title'> <span class='icon'> <i class='icon-align-justify'></i> </span> 
          	<h5>资源监控</h5>
        	</div>  
        	<div class='widget-content nopadding'>
			<div class='form-horizontal'>
			<div class='control-group'>
              <label class='control-label'>主机名host :</label>
              <div class='controls'>
                <input id='hostname' type='text' placeholder='cp01-testing-bdcm06.cp01.baidu.com' value='".$module_server."' class='span6'>
              </div>
            </div>	
			<div class='control-group'>
              <label class='control-label'>开始时间 :</label>
              <div class='controls'>
                <input id='start_date' type='text' placeholder='yyyyMMddHHmmss' class='span6' value='".$starttime."'>
              </div>
            </div>	
			<div class='control-group'>
              <label class='control-label'>结束时间 :</label>
              <div class='controls'>";
			
		if($stoptime == "0000-00-00 00:00:00"){
			$stoptime = date("Y-m-d H:i:s");
		}
		echo "
                <input id='end_date' type='text' placeholder='yyyyMMddHHmmss' class='span6' value='".$stoptime."'>
              </div>
            </div>	
		";
	
	}else{
		echo "
		  <div class='row-fluid'>
		      <div class='span10'>
		<div class='widget-box'>
        	<div class='widget-title'> <span class='icon'> <i class='icon-align-justify'></i> </span> 
          	<h5>资源监控</h5>
        	</div>  
        	<div class='widget-content nopadding'>
			<div class='form-horizontal'>
			<div class='control-group'>
              <label class='control-label'>主机名host :</label>
              <div class='controls'>
                <input id='hostname' type='text' placeholder='cp01-testing-bdcm06.cp01.baidu.com' class='span6'>
              </div>
            </div>	
			<div class='control-group'>
              <label class='control-label'>开始时间 :</label>
              <div class='controls'>
                <input id='start_date' type='text' placeholder='yyyyMMddHHmmss' class='span6'>
              </div>
            </div>	
			<div class='control-group'>
              <label class='control-label'>结束时间 :</label>
              <div class='controls'>
                <input id='end_date' type='text' placeholder='yyyyMMddHHmmss' class='span6'>
              </div>
            </div>	
		";
	}
?>
		
	<div class='control-group'>
		  <label class='control-label'>监控项 :</label>
		  <div class='controls'>
			  <input id="cpu_idle" value="CPU_IDLE" type='checkbox' checked='checked' name='radios'>
			  CPU闲置时间</input>&nbsp;&nbsp;&nbsp;
			  <input id="mem_urate" value="MEM_URATE" type='checkbox' name='radios'>
			  物理内存使用率</input>&nbsp;&nbsp;&nbsp;
			  <input id="load_avg1" value="SERVER_LOADAVG1" type='checkbox' name='radios'>
			  1分钟平均负载</input>&nbsp;&nbsp;&nbsp;
			  <input id="io_avg_wait" value="IO_AVGWAIT" type='checkbox' name='radios' >
			  平均I/O等待时间</input>
		  </div>
	</div>
 	
	<div class="form-actions">
              <button onclick='checkArgs()' class="btn btn-success">查询并显示资源图像</button>
              <button onclick='showProOcean()' class="btn btn-primary">进程监控</button>
    </div>
	</div>
</div>
</div>
</div>
</div>


<iframe id="pro_frame" name="pro_frame" width=100% height=100% frameborder=0 onload="this.height=pro_frame.document.body.scrollHeight" style="display:none;"></iframe>
<!--
<div id='pro_panel' style="display:none;">
<font size='2'><strong>进程监控  <label id='host_label'></label></strong></font><br/>
</div>
-->
<div><br/><hr/><font size="1px">*点击访问<a href='http://ocean.baidu.com/' target='_blank'>Ocean开发测试云</a>查询更多资源监控.</font></div>

</div>
</div>

<script type="text/javascript" src="./ocean.js"></script>
<?php
	require_once('/home/work/renm/apache/apache2/htdocs/clientbest/web/foot.php');
?>
