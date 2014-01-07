<html>
<head>
<meta http-equiv=Content-Type content="text/html; charset=utf-8">
<link href="./../css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="./op_ocean.js"></script>
</head>
<body>

<?php
	//$host = "cp01-testing-bdcm06.cp01.baidu.com";
	$host = $_GET["host"];
	$app = $_GET["app"];
	$endTime = $_GET["endtime"];
	//if(isset($endTime)){
	//	preg_match_all('/\d/S',$endTime, $matches);
	//	$endTime = implode('',$matches[0]);
	//}
	$account = $_GET["account"];
	$status = $_GET["status"];
	
	echo "<br/><br/>";	
	echo "<font size='2'><strong>进程监控 ".$host."</strong></font><br/>";
	echo "<table>";
	echo "<tr><td>*进程: </td>";
	if(!isset($app)){
		//add
		echo "<td><input id='input_app' type='text'></td>";
	}else{
		echo "<td id='label_app'>".$app."</td>";
	}
	echo "</tr>";

	echo "<tr><td>*停止时间: &nbsp;</td><td><input id='input_endtime' type='text' placeholder='yyyyMMddHHmmss' value='".$endTime."'></td></tr>";
	echo "<tr><td>*所在帐号: </td><td><input id='input_account' type='text' value='".$account."'></td></tr>";
	echo "<tr><td>*帐号密码: </td><td><input id='input_password' type='text'></td></tr>";
	echo "</table>";
	
	echo "<button onclick=\"backToList('".$host."')\">返回</button>&nbsp;&nbsp;&nbsp;";
	if(!isset($app)){
		//add
		echo "<button onclick=\"update('add','".$host."')\">添加</button>";
	}else{
		if($status==1){
			echo "<button onclick=\"stop('".$host."')\">停止</button>&nbsp;&nbsp;&nbsp;";
		}else{
			echo "<button onclick=\"start('".$host."')\">开启</button>&nbsp;&nbsp;&nbsp;";
		}
		echo "<button onclick=\"update('update','".$host."')\">修改</button>&nbsp;&nbsp;&nbsp;";
		echo "<button onclick=\"delete_app('".$host."')\">删除</button>";
	}
?>
</body>
</html>
