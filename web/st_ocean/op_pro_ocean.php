<html>
<head>
<meta http-equiv=Content-Type content="text/html; charset=utf-8">
<meta http-equiv=html content=no-cache>
<link href="./../css/bootstrap.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="./op_ocean.js"></script>
</head>
<body>

<font size='2'><strong>进程监控</strong></font><br/>
<?php
	if(isset($_GET["op"])){
		
	}
	//$host = "cp01-testing-bdcm06.cp01.baidu.com";
	$host = $_GET["host"];
	$app = $_GET["app"];
	$endTime = $_GET["endtime"];
	$account = $_GET["account"];
	$status = $_GET["status"];
	
	$query_url = "http://ocean.baidu.com/realtime/listAppsByHost/?host=".$host;

	$update_url = "http://ocean.baidu.com/realtime/newAppMon/?host=".$host."&appName=java&account=work&endTime=20121009150000&password=www";

	$start_url = "http://ocean.baidu.com/realtime/turnOn/?host=".$host."&appName=java&account=work&password=www";
	$stop_url = "http://ocean.baidu.com/realtime/turnOff/?host=".$host."&appName=java&account=work&password=www";
	$delete_url = "http://ocean.baidu.com/realtime/removeApp/?host=".$host."&appName=java&account=work&password=www";

	echo "Host: ".$host."<br/>";
	echo "<table>";
	echo "<tr><td>进程: </td>";
	if(!isset($app)){
		//add
		echo "<td><input id='input_app' type='text'></td>";
	}else{
		echo "<td id='label_app'>".$app."</td>";
	}
	echo "</tr>";

	echo "<tr><td>停止时间: </td><td><input id='input_endtime' type='text' value='".$endTime."'></td></tr>";
	echo "<tr><td>所在帐号: </td><td><input id='input_account' type='text' value='".$account."'></td></tr>";
	echo "<tr><td>帐号密码: </td><td><input id='input_password' type='text'></td></tr>";
	echo "</table>";
	
	if(!isset($app)){
		//add
	echo "<button onclick=\"add('".$host."')\">添加</button>";
	}else{
		if($status==1){
		echo "<button onclick=\"stop('".$host."')\">停止</button>";
		}else{
		echo "<button onclick=\"start('".$host."')\">开启</button>";
		}
	echo "<button onclick=\"update('".$host."')\">修改</button>";
	echo "<button onclick=\"delete_app('".$host."')\">删除</button>";
	}

?>
</body>
</html>
