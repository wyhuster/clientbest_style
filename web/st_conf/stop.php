<?php
	error_reporting(E_ALL);
	require_once("/home/work/renm/apache/apache2/htdocs/clientbest/web/common.php");

?>

<html><head>
<title>停止测试</title>
<meta http-equiv=Content-Type content="text/html; charset=utf-8">
<meta http-equiv=html content=no-cache>
<link href="./../css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="./../js/conf.js"></script>
</head>

<body bgcolor="#FAFCFF" >
<div>
<h3 align="left">停止测试</h3>
<hr/>
</div>
<br/>
<br/>

<?php
	$id = $_POST['id'];
	if(!isset($id) || $id == NULL ){
		echo "请输入参数 id.\n";
		return;
	}
	$model = AbstractPressModel::reload($id);
	if(!$model){
		echo "error id = $id.\n";
		return;
	}
	$model->stop();
	echo "测试已停止.\n"
?>
</body>
</html>
