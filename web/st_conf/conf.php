<?php
	error_reporting(E_ALL);
	require_once('/home/work/renm/apache/apache2/htdocs/clientbest/web/common.php');
?>

<html><head>
<title>测试部署</title>
<meta http-equiv=Content-Type content="text/html; charset=utf-8">
<meta http-equiv=html content=no-cache>
<link href="./../css/style.css" rel="stylesheet" type="text/css" />
<!--<link href="./../css/bootstrap.css" rel="stylesheet" type="text/css" />-->
<script type="text/javascript" src="./../js/conf.js"></script>
</head>

<body bgcolor="#FAFCFF" >
<div>   
<h3 align="left">测试部署</h3>
<hr/>
</div>

<?php 
    $model = running_model();
	if($model){
		echo "<p align = center style='font-family:Arial;font-size:20px;padding-top:15px; font-weight:bolder;' >您部署的测试正在运行中...<p>";
		$model->show();
		return;
	}

?>


<div id="press_model_hending" style="display:none" >
	<table name="press_model_table">
		<tr>
		<td id="conf_args_name">qps：</td>
		<td>
		<input type="text" size="8" name="qps" maxlength="5" onkeyup="onlynum(this)" onafterpaste="onlynum(this)"></input>
		</td>
		</tr>
		<tr>
		<td id="conf_args_name">时间(min)：</td>
		<td>
		<input type="text" size="8" name="time" maxlength="5" onkeyup="onlynum(this)" onafterpaste="onlynum(this)"></input>
		</td>
		</tr>
	</table>
</div>


<div id="press_model_jieti" style="display:none">
	<table name="press_model_table">
		<tr>
		<td id="conf_args_name">开始qps：</td>
		<td>
		<input type="text" size="8" name="qps_start" maxlength="5" onkeyup="onlynum(this)" onafterpaste="onlynum(this)"></input>
		</td>
		</tr>
		<tr><td id="conf_args_name">结束qps：</td>
		<td>
		<input type="text" size="8" name="qps_end" maxlength="5" onkeyup="onlynum(this)" onafterpaste="onlynum(this)"></input>
		</td>
		</tr>
		<tr><td id="conf_args_name">qps间隔：</td>
		<td>
		<input type="text" size="8" name="qps_interval" maxlength="5" onkeyup="onlynum(this)" onafterpaste="onlynum(this)"></input>
		</td>
		</tr>
		<tr>
		<td id="conf_args_name">每qps压力时间(min)：</td>
		<td>
		<input type="text" size="8" name="time_interval" maxlength="5" onkeyup="onlynum(this)" onafterpaste="onlynum(this)"></input>
		</td>
		</tr>
	</table>
</div>


<div id="press_model_langyong" style="display:none">
	<table name="press_model_table">
		<tr>
		<td id="conf_args_name">最低qps：</td>
		<td>
		<input type="text" size="8" name="low_qps" maxlength="5" onkeyup="onlynum(this)" onafterpaste="onlynum(this)"></input>
		</td>
		</tr>
		<tr><td id="conf_args_name">最高qps：</td>
		<td>
		<input type="text" size="8" name="high_qps" maxlength="5" onkeyup="onlynum(this)" onafterpaste="onlynum(this)"></input>
		</td>
		</tr>
		<tr>
		<td id="conf_args_name">时间间隔(min)：</td>
		<td>
		<input type="text" size="8" name="time_interval" maxlength="5" onkeyup="onlynum(this)" onafterpaste="onlynum(this)"></input>
		</td>
		</tr>
		<tr>
		<td id="conf_args_name">时间(min)：</td>
		<td>
		<input type="text" size="8" name="time" maxlength="5" onkeyup="onlynum(this)" onafterpaste="onlynum(this)"></input>
		</td>
		</tr>
	</table>
</div>


<div id="press_model_zhengdang" style="display:none">
	<table name="press_model_table">
		<tr>
		<td id="conf_args_name">最低qps：</td>
		<td>
		<input type="text" size="8" name="low_qps" maxlength="5" onkeyup="onlynum(this)" onafterpaste="onlynum(this)"></input>
		</td>
		</tr>
		<tr>
		<td id="conf_args_name">最高qps：</td>
		<td>
		<input type="text" size="8" name="high_qps" maxlength="5" onkeyup="onlynum(this)" onafterpaste="onlynum(this)"></input>
		</td>
		</tr>
		<tr>
		<td id="conf_args_name">时间(min)：</td>
		<td>
		<input type="text" size="8" name="time" maxlength="5" onkeyup="onlynum(this)" onafterpaste="onlynum(this)"></input>
		</td>
		</tr>
	</table>
</div>


<form method="post" action="bushu.php">
<table width = 100% cellpading=2 cellspacing=2 border=0>
<tr>
<td>
	<table width=800px  cellpadding=2 cellspacing=0 border=1 align="left">  
		<tr>
		<td valign="top" align=left width="120px">测试类型</td>
		<td algin="left">
			<table>  
			<tr>
			<td id="conf_args_name">类型：</td>
			<td>
				<select name="test_type" id="test_type" size="1">
				<option value="http" selected=true>http</option>
				</select>
			</td>
			</tr>
			</table>
		</td>
		</tr>

		<tr>
		<td valign="top" align=left>测试工具</td>
		<td>
			<table>  
			<tr>
			<td  id="conf_args_name">工具：</td>
			<td>
				<select name="test_tool" id="test_tool" size="1">
				<option value="curlpress" selected=true>curlpress</option>
				</select>
			</td>
			</tr>
			<tr>
			<td  id="conf_args_name">运行服务器：</td>
			<td>
				<select id="run_server" name="run_server" size="1">
				<option value="cp01-testing-bdcm05.cp01.baidu.com" selected=true>bdcm05</option>
				<option value="cp01-testing-bdcm06.cp01.baidu.com">bdcm06</option>
				<option value="cp01-testing-bdcm07.cp01.baidu.com">bdcm07</option>
				<option value="cp01-testing-bdcm08.cp01.baidu.com">bdcm08</option>
				</select>
			</td>
			</tr>
			</table>
	
			<hr id="fengefu" >

			<div id="tool_curlpress">
				<table id='tb_curlpress'>
					<tr>
					<td id="conf_args_name">请求方式：</td>
					<td>
					<input type="radio" name="request_method" value="GET" checked onclick='showPostData(false)'>GET</input>
					<input type="radio" name="request_method" value="POST" onclick='showPostData(true)'>POST</input>
					</td>
					</tr>
					<tr>
					<td id="conf_args_name">url：</td>
					<td>
					<input id="request_url" name="request_url" type="text" value=""  size="40"/>												
					</td>
					</tr>
					<tr>
					<td id="conf_args_name">post data：</td>
					<td><input type="text" name="request_data" size="40"/></td>
					</tr>
					<tr>
					<td  id="conf_args_name">cookie：</td>
					<td><input type="text" name="request_cookie" size="40"/></td>
					</tr>
				</table>
			</div>

		</td>
		</tr>
	
		<tr>
		<td valign="top" align=left>被测服务</td>
		<td>
			<table>  
			<tr>
			<td  id="conf_args_name">主机名host：</td>
			<td><input id="server_name" name="server_name" type="text" value=""  size="40"/></td>
			</tr>
			</table>
			<font size=2>*ocean资源查看需要主机名</font><br/>
		</td>
		</tr>
	
		 <tr>
		 <td valign="top" align=left>压力模型</td>
		 <td>
			<table>  
			<tr>
			<td id="conf_args_name">模型：</td>
			<td>
				<select name="press_model" id="press_model" size="1" onchange="change_press_model(this)">
				<option value="hengding" selected=true>恒定</option>
				<option value="jieti" >阶梯</option>
				<option value="zhendang" >震荡</option>
				<option value="langyong" >浪涌</option>
				</select>
			</td>
			</tr>
			</table>
			<hr id="fengefu"/>
			<div id = "press_model_args"></div>
		</td>
		</tr>
	</table>
</td>
</tr>
<tr>
<td>
	&nbsp;&nbsp;<input type="submit" value="部署" onclick="return checkArgs()"></input>
</td>
</tr>
</table>
</form>
</body>
</html>

<script type="text/Javascript">
	window.onload=load;
</script>

