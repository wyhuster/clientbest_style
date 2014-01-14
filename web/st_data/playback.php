<?php
	error_reporting(E_ALL);
	require_once("/home/work/renm/apache/apache2/htdocs/clientbest/web/common.php");
	require_once("/home/work/renm/apache/apache2/htdocs/clientbest/web/head.php");
	require_once("/home/work/renm/apache/apache2/htdocs/clientbest/web/st_data/side_menu.php");

?>
<div id="content">
<div id="content-header">
  <div id="breadcrumb"> 
      <a href="../index.php" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> 
      <a href="data_show.php" class="tip_bottom">数据回放</a> <a href="" class="current">回放结果</a>  
  </div>  
</div>
<div class="container-fluid">

<?php
	$model = running_model();
	if($model){
		echo "<p align = center style='font-family:Arial;font-size:20px;padding-top:15px; font-weight:bolder;' >您部署的测试正在运行中...<p>";
		$model->show();
		echo "<br>";
		echo "<script> alert('您已经在运行测试了，请先停止先前的测试！');</script>";
		return;
	}
	$id = $_GET['id'];
	if(!isset($id) || $id == NULL ){
		echo "请输入参数 id.\n";
		return;
	}
	$model = AbstractPressModel::reload($id);
	if(!$model){
		echo "error id = $id.\n";
		return;
	}
	if($model->isRunning()){
		echo "<p align = center style='font-family:Arial;font-size:20px;padding-top:15px; font-weight:bolder;' >该测试正在运行中...<p>";
		$model->show();
		echo "<br>";
		echo "<script> alert('当前测试已经在运行,但它可能不是由您启动的，若想重新启动，请先停止!!');</script>";
		return;
	}
	//分别部署负载控制工具和压力测试工具
	//$loader->execute();
	$_SESSION['press_id'] = $model->execute();
	$model->show();
?>
</div>
</div>
<?php
	require_once('/home/work/renm/apache/apache2/htdocs/clientbest/web/foot.php');
?>
