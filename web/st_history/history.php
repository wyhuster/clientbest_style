<?php
	error_reporting(E_ALL);
	require_once("/home/work/renm/apache/apache2/htdocs/clientbest/web/common.php");
	require_once("/home/work/renm/apache/apache2/htdocs/clientbest/web/tools/factory.php");
	require_once("/home/work/renm/apache/apache2/htdocs/clientbest/web/head.php");
	require_once("/home/work/renm/apache/apache2/htdocs/clientbest/web/st_history/side_menu.php");
?>

<!--main-container-part-->
<div id="content">
<!--breadcrumbs-->
  <div id="content-header">
    <div id="breadcrumb"> 
    <a href="../index.php" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a>
    <a href="" class="current">使用记录</a>
    </div>  
  </div>  
  <!--End-breadcrumbs-->
<div class="container-fluid">

<table class="table table-hover">
<thead>
<tr>
<th>编号</th>
<!--<th>压力模型</th>-->
<!--<th>协议类型</th>
<th>工具名称</th>-->
<th>压力运行服务器</th>
<!--<th>压力参数</th>-->
<th>请求参数</th>
<th>使用时间</th>
<th>Log</th>
<th>Ocean</th>
<th>Report</th>
</tr>
</thead>
<tbody>

<?php

	class ModelRow{
	  var $columns;
	  function __construct(){
	   $this->columns = array();
	  }
	  function add_column($column_value){
	   array_push($this->columns, $column_value);
	  }

	  function add_time_row($time){
		$array = explode("--",$time);
		$row_content = "";
		foreach($array as $value){
			if($value == "0000-00-00 00:00:00"){
				$row_content = $row_content."<font color='red'>running</font><br/>";
			}
			else{
				$row_content = $row_content.$value."<br/>"; 
			}
		}
		array_push($this->columns, $row_content);
	  }
	  
	  function add_tool_args_row($tool_args){
		$row_content = "";
        foreach($tool_args["tool_args"] as $key => $value){
			if($key != "data" and $key != "cookie"){
				if(strlen($value)>25){
					$value=substr($value,0,25)."...";
				}
				$row_content = $row_content.$key."=".htmlspecialchars($value)."<br/>";
			}
	    }
	   
	   $conf_file = $row_content.$tool_args["config_filedir"];
	   $conf_file_arr=explode("/",$conf_file);
	   $length_conf_file=sizeof($conf_file_arr);
	   $index = $length_conf_file-1;
	   $file_path="/home/work/renm/apache/apache2/htdocs/clientbest/configfiles/".$conf_file_arr[$index]."/";
	   $handle=opendir($file_path);
	   $file_index=0;
	   while($file=readdir($handle))
	   {
		if   (($file!= ".")and($file!= ".."))
		{
		  $list[$file_index]=$file;
		  $file_index=$file_index+1;
		}
		
	   }
	   closedir($handle);
	   $file_num=sizeof($list);
	   for($index=0;$index<$file_num;$index++)
	   {
		   if($list[$index] != "python.pid"){
				$row_content = $row_content."<a href='/clientbest/web/st_history/history_conf_content.php?filepath=".$file_path.$list[$index]."'>".$list[$index]."</a>&nbsp;&nbsp;&nbsp;";
			}
		}
	   
	   array_push($this->columns, $row_content);
	  }

	  function add_log_row($id){
		$row_content = "";
		$file_path="/home/work/renm/apache/apache2/htdocs/clientbest/logs/".$id."_curlpress_log/";
	   	if(!is_dir($file_path)){
			array_push($this->columns, $row_content);
			return;
		}
		$handle=opendir($file_path);
	   	$file_index=0;
	   	while($file=readdir($handle))
	   	{
			if(($file!= ".")and($file!= "..")and($file!= "python.pid"))
			{
		  		$list[$file_index]=$file;
		  		$file_index=$file_index+1;
			}
	   	}
	   	closedir($handle);
		if(isset($list)){
			$file_num=sizeof($list);
			for($index=0;$index<$file_num;$index++)
			{
				$row_content = $row_content."<a href='/clientbest/web/st_history/history_conf_content.php?log=1&filepath=".$file_path.$list[$index]."'>".$list[$index]."</a><br/>";
			}
		}
		array_push($this->columns, $row_content);
	  }


	function addServerRow($model){
		$row_content = "";
		//get press server name
		$server_name_arr = explode("-",$model->getPressServer());
	    $server_name_length = sizeof($server_name_arr);
	    $server_name_index = ($server_name_length-1);
	    $str_name_arr = $server_name_arr[$server_name_index];
	    $name_arr = explode(".",$str_name_arr);
	    $server_name=$name_arr[0];

		$row_content = $row_content.$server_name;

		
		$pid = $model->getPid();
		if($pid!=""){
			$row_content = $row_content."<br/>pid: ".$pid;
		}
		array_push($this->columns, $row_content);
	}

	function render(){
	   $html_content = "<tr>";
	   foreach($this->columns as $value){
	    $html_content = $html_content."<td>".$value."</td>";
	   }	
	   $html_content = $html_content."</tr>";
	   return $html_content;
	}

	}
	
	$all_model = AbstractPressModel::all_history_models();
	
	foreach($all_model as $model)
	{
	  $model_row = new ModelRow();
	  $model_row->add_column($model->getId());
	  //$model_row->add_column($model->getPressModel());
	  //$model_row->add_column($model->getProtocolType());
	  //$model_row->add_column($model->getToolName());
	  $model_row->addServerRow($model);
	  //$model_row->add_column($model->getPressArgs());
	  $model_row->add_tool_args_row($model->getToolArgs());
	  //$model_row->add_column($model->getUpdatetime());
	  $model_row->add_time_row($model->getUpdatetime());
	  //$model_row->add_column($model->getInfo());
	  $model_row->add_log_row($model->getId());
	  $model_row->add_column("<a href='/clientbest/web/st_ocean/ocean.php?id=".$model->getId()."'>view</a>");
	  if($model->getPressModel() == "阶梯"){
		  $model_row->add_column("<a href='/clientbest/web/st_history/view_report.php?id=".$model->getId()."'>view</a>");
	  }else{
		$model_row->add_column("");
	  }
 	  echo $model_row->render();
	  //$file_path=$model->getToolContent();
	  //$file = "/home/work/web/clientbest/web/configfiles/".$file_path."/press.conf";
	  //$content = file_get_contents($file);
	  //echo $content;
	}
//	$model->save();
	//分别部署负载控制工具和压力测试工具
//	$loader->execute();
	//$model->execute();
?>
</tbody>
</table>
</div>
</div>
<?php
require_once('/home/work/renm/apache/apache2/htdocs/clientbest/web/foot.php');
?>
