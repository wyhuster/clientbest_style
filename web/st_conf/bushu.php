<?php
	require_once('/home/work/renm/apache/apache2/htdocs/clientbest/web/common.php');
?>

<html><head>
<title>测试部署</title>
<meta http-equiv=Content-Type content="text/html; charset=utf-8">
<meta http-equiv=html content=no-cache>
<link href="./../css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="./../js/conf.js"></script>
</head>

<body bgcolor="#FAFCFF" >
<div>
<h3 align="left">测试部署</h3>
<hr/>
<p>
</div>

<?php
	$model = running_model();
        if($model){
                $model->show();
                echo "<br>";
                echo "<input type=button value='停止'/>";
                echo "<script> alert('您已经在运行测试了，请先停止先前的测试！');</script>";
                return;
        }

	$type_name = $_POST['test_type'];
	echo "测试类型: ".$type_name."<br>";

	echo "<hr>";
	$loader = ToolFactory::getTool("loader");
	$loader->parseConfig($_POST);
	$loader->generateConfig(0);
	$loader->show();

	echo "<hr>";
	$model = PressModelFactory::getModel($_POST['press_model']);

	$model->parseArgs($_POST);
	$model->generateConfig();
	$model->show();
	//分别部署负载控制工具和压力测试工具
	//$loader->execute();
	$press_id= $model->execute();
	$_SESSION['press_id'] = $press_id; 
?>
</body>
</html>
