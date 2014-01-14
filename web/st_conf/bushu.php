<?php
	require_once('/home/work/renm/apache/apache2/htdocs/clientbest/web/common.php');
	require_once('/home/work/renm/apache/apache2/htdocs/clientbest/web/head.php');
	require_once('/home/work/renm/apache/apache2/htdocs/clientbest/web/st_conf/side_menu.php');
?>
<!--main-container-part-->
<div id="content">
<!--breadcrumbs-->
  <div id="content-header">
    <div id="breadcrumb"> 
    <a href="../index.php" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a>
    <a href="conf.php" class="tip_bottom">测试部署</a>
    <a href="" class="current">部署情况</a>
    </div>  
  </div>  
  <!--End-breadcrumbs-->
<div class="container-fluid">

<?php
	$model = running_model();
	if($model){
			$model->show();
			echo "<br>";
			echo "<input type=button value='停止'/>";
			echo "<script> alert('您已经在运行测试了，请先停止先前的测试！');</script>";
			return;
	 }

	//$type_name = $_POST['test_type'];
	//echo "测试类型: ".$type_name."<br>";

	//echo "<hr>";
	//$loader = ToolFactory::getTool("loader");
	//$loader->parseConfig($_POST);
	//$loader->generateConfig(0);
	//$loader->show();

	//echo "<hr>";
	$model = PressModelFactory::getModel($_POST['press_model']);

	$model->parseArgs($_POST);
	$model->generateConfig();
	$model->show();
	//分别部署负载控制工具和压力测试工具
	//$loader->execute();
	$press_id= $model->execute();
	$_SESSION['press_id'] = $press_id; 
?>
</div>
</div>

<?php
	require_once('/home/work/renm/apache/apache2/htdocs/clientbest/web/foot.php');
?>
