<html>
<head>
<meta http-equiv=Content-Type content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="/clientbest/web/css/bootstrap.min.css" />
<link rel="stylesheet" href="/clientbest/web/css/bootstrap-responsive.min.css" />
<link rel="stylesheet" href="/clientbest/web/css/bootstrap-wysihtml5.css" />
<link rel="stylesheet" href="/clientbest/web/css/colorpicker.css" />
<link rel="stylesheet" href="/clientbest/web/css/datepicker.css" />
<link rel="stylesheet" href="/clientbest/web/css/fullcalendar.css" />
<link rel="stylesheet" href="/clientbest/web/css/jquery.gritter.css" />
<link rel="stylesheet" href="/clientbest/web/css/matrix-login.css" />
<link rel="stylesheet" href="/clientbest/web/css/matrix-media.css" />
<link rel="stylesheet" href="/clientbest/web/css/matrix-style.css" />
<link rel="stylesheet" href="/clientbest/web/css/select2.css" />
<link rel="stylesheet" href="/clientbest/web/css/uniform.css" />
<link rel="stylesheet" href="/clientbest/web/font-awesome/css/font-awesome.css" />
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
<script type="text/javascript" src="./op_ocean.js"></script>
</head>
<body style="background: none repeat scroll 0 0 #eeeeee;">
<div id="content_test">

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
	echo "<font size='2'><strong>进程监控 ".$host."</strong></font>";
	echo "<br/>";
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

	echo "<div id='div_btn'>";
	echo "<button class='btn btn-success' onclick=\"backToList('".$host."')\">返回</button>&nbsp;&nbsp;&nbsp;";
	if(!isset($app)){
		//add
		echo "<button class='btn btn-primary' onclick=\"update('add','".$host."')\">添加</button>";
	}else{
		if($status==1){
			echo "<button class='btn btn-primary' onclick=\"stop('".$host."')\">停止</button>&nbsp;&nbsp;&nbsp;";
		}else{
			echo "<button class='btn btn-primary' onclick=\"start('".$host."')\">开启</button>&nbsp;&nbsp;&nbsp;";
		}
		echo "<button class='btn btn-info' onclick=\"update('update','".$host."')\">修改</button>&nbsp;&nbsp;&nbsp;";
		echo "<button class='btn btn-danger' onclick=\"delete_app('".$host."')\">删除</button>";
	}
	echo "</div>";
	
	echo "<div id='div_loading' style='display:none;'>";
	echo "<img id='loading' src='./../img/loading.gif'>";
	echo "</div>";
?>
</div>
</body>
</html>
