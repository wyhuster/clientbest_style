<html>
<head>
<meta http-equiv=Content-Type content="text/html; charset=utf-8">
<meta http-equiv=html content=no-cache>
<link href="./../css/bootstrap.css" rel="stylesheet" type="text/css" />
</head>
<body>

<font size='2'><strong>进程监控</strong></font><br/>
<?php
	$host = "cp01-testing-bdcm06.cp01.baidu.com";
	echo "<a href='op_pro_ocean.php?host=".$host."'>添加</a>";
?>
<table class="table table-hover">
<thead>
<tr>
<th>appName</th>
<th>类型</th>
<th>所属帐号</th>
<th>添加时间</th>
<th>停止时间</th>
<th>添加用户</th>
<th>状态</th>
<th>操作</th>
</tr>
</thead>
<tbody>
<?php
	$query_url = "http://ocean.baidu.com/realtime/listAppsByHost/?host=".$host;
	
	$xml = simplexml_load_file($query_url);
	
	foreach($xml->app as $app){
		echo "<tr>";
		echo "<td>".$app->appName."</td>";
		if($app->type==1){
			echo "<td>进程名</td>";
		}else{
			echo "<td>进程号</td>";
		}
		echo "<td>".$app->account."</td>";
		echo "<td>".$app->startTime."</td>";
		echo "<td>".$app->endTime."</td>";
		echo "<td>".$app->userName."</td>";
		if($app->status==1){
			echo "<td>running</td>";
		}else{
			echo "<td>stop</td>";
		}
		echo "<td><a href='op_pro_ocean.php?host=".$host."&app=".$app->appName."&endtime=".$app->endTime."&account=".$app->account."&status=".$app->status."'>操作</a></td>";
		echo "</tr>";
	}
?>
</tbody>
</table>
</body>
</html>
