<?php
	error_reporting(E_ALL);
	#require_once('../inc/commen.php');
	require_once("/home/work/renm/apache/apache2/htdocs/clientbest/web/tools/factory.php");
	#$timeNow = time();

?>

<html><head>
<title>使用历史</title>
<meta http-equiv=Content-Type content="text/html; charset=utf-8">
<meta http-equiv=html content=no-cache>
<link href="./../css/bootstrap.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="./../js/conf.js"></script>
</head>

<body bgcolor="#FAFCFF" >
<div class="">
<table class="table table-hover">

<thead>
<tr>
<td>编号</td>
<td>压力模型</td>
<td>协议类型</td>
<td>工具名称</td>
<td>压力运行服务器</td>
<td>压力参数</td>
<td>配置文件</td>
<td>说明</td>
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

	  function add_tool_args_row($tool_args){
	   $row_content = "";
           foreach($tool_args["tool_args"] as $key => $value){
	    $row_content = $row_content.$key."=".$value."<br/>";

	   }
	   
	   $conf_file = $row_content.$tool_args["config_filedir"];
	   $conf_file_arr=explode("/",$conf_file);
	   $length_conf_file=sizeof($conf_file_arr);
	   $index = $length_conf_file-1;
	   $file_path="/home/work/web/clientbest/web/configfiles/".$conf_file_arr[$index]."/";
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
	   $row_content = $row_content."conf=";
	   for($index=0;$index<$file_num;$index++)
	   {
		$row_content = $row_content.$list[$index]."<br/>";
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

	$all_model = AbstractPressModel::all_models();
	foreach($all_model as $model)
	{
	  $model_row = new ModelRow();
	  $model_row->add_column($model->getId());
	  $model_row->add_column($model->getPressModel());
	  $model_row->add_column($model->getProtocolType());
	  $model_row->add_column($model->getToolName());
	  $model_row->add_column($model->getPressServer());
	  $model_row->add_column($model->getPressArgs());
	  $model_row->add_tool_args_row($model->getToolArgs());
	  $model_row->add_column($model->getInfo());
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
</body>
</html>
