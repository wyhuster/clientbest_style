<html>
<head>
<title>Ocean监控</title>
<meta http-equiv=Content-Type content="text/html; charset=utf-8">
<meta http-equiv=html content=no-cache>
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
	echo "<br/><br/>";
	$host = $_GET["host"];
	echo "<font size='2'><strong>进程监控 ".$host."</strong></font><br/>";
?>
<table class="table table-hover">
<thead>
<tr>
<th>进程</th>
<th>类型</th>
<th>所属帐号</th>
<th>添加时间</th>
<th>停止时间</th>
<th>添加用户</th>
<th>状态</th>
<th>操作</th>
<th>监控图像</th>
</tr>
</thead>
<tbody>
<?php
	$query_url = "http://ocean.baidu.com/realtime/listAppsByHost/?host=".$host;
	
	$xml = simplexml_load_file($query_url);
	
	foreach($xml->app as $app){
		echo "<tr>";
		echo "<td>".$app->appName."</td>";
		echo "<td>".$app->type;
		if($app->type==1){
			echo ":进程名</td>";
		}else{
			echo ":进程号</td>";
		}
		echo "<td>".$app->account."</td>";
		echo "<td>".$app->startTime."</td>";
		echo "<td>".$app->endTime."</td>";
		echo "<td>".$app->userName."</td>";
		echo "<td>".$app->status;
		if($app->status==1){
			echo ":running</td>";
		}else{
			echo ":stop</td>";
		}
		echo "<td><a href='op_pro_ocean.php?host=".$host."&app=".$app->appName."&endtime=".$app->endTime."&account=".$app->account."&status=".$app->status."'>操作</a></td>";
		echo "<td><a href=\"javascript:viewOceanData('".$host."','".$app->appName."')\">查看</a></td>";
		echo "</tr>";
	}
?>
</tbody>
</table>
<?php echo "<a class='btn btn-success' href='op_pro_ocean.php?host=".$host."'>添加</a>";?>
</div>
</body>
</html>
