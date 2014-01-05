<?php
	error_reporting(E_ALL);
	#require_once('../inc/commen.php');
	require_once("/home/work/renm/apache/apache2/htdocs/clientbest/web/tools/factory.php");
	#$timeNow = time();

?>

<html><head>
<title>测试回放</title>
<meta http-equiv=Content-Type content="text/html; charset=utf-8">
<meta http-equiv=html content=no-cache>
<link href="./../css/bootstrap.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="./../js/conf.js"></script>
</head>
<script language=javascript>

</script>
<body bgcolor="#FAFCFF" >
<div class="">
<table class="table table-hover">

<thead>
<tr>
<th>协议类型</th>
<th>工具名称</th>
<th>压力运行服务器</th>
<th>压力参数</th>
<th>配置文件</th>
<th>压力模型</th>
<th>压力测试回放</th>
</tr>
</thead>
<tbody>

<?php

	class ModelRow{
	  var $columns;
	  function __construct()
	  {
	  	 $this->columns = array();
	  }
	  
	  function add_column($column_value)
	  {
	  	 array_push($this->columns, $column_value);
	  }

	  function add_tool_args_row($tool_args)
	  {
		$row_content = "";
		foreach($tool_args["tool_args"] as $key => $value)
	    	{
	    		$row_content = $row_content.$key."=".htmlspecialchars($value)."<br>";
	   	}
	   	$conf_file = $row_content.$tool_args["config_filedir"];
	   	$conf_file_arr=explode("/",$conf_file);
	   	$length_conf_file=sizeof($conf_file_arr);
	   	$index = $length_conf_file-1;
	   	$file_path="/home/work/renm/apache/apache2/htdocs/clientbest/web/configfiles/".$conf_file_arr[$index]."/";
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
			$row_content = $row_content."<a href='/clientbest/web/st_data/data_conf_content.php?filepath=".$file_path.$list[$index]."'>".$list[$index]."</a><br/>";
	   	}
	   	array_push($this->columns, $row_content);
	  }
 
	  function add_hyper_column($column_value,$model)
	  {
		$row_content = "";
		if(!$model->isRunning())
			$row_content = "<a href='/clientbest/web/st_data/playback.php?id=".$column_value."' onclick=\"return confirm('您将要在服务器".
			getServerName($model->getPressServer())."上运行".$model->getToolName()."，您确定要进行回放吗？');\">测试回放</a>";
		else
			$row_content = "<a target=_blank href='/clientbest/web/st_monitor/monitor.php?id=".$column_value." '>监控</a>";

	   	array_push($this->columns, $row_content); 
	  }

	  function render()
	  {
	  	$html_content = "<tr>";
	  	foreach($this->columns as $value)
		{
	    		$html_content = $html_content."<td>".$value."</td>";
	  	}	
	  	$html_content = $html_content."</tr>";
	   	return $html_content;
	  }
}

	function getServerName($str)
	{
		$server_name_arr = explode("-",$str);
		$server_name_length = sizeof($server_name_arr);
		$server_name_index = ($server_name_length-1);
		$str_name_arr = $server_name_arr[$server_name_index];
		$name_arr = explode(".",$str_name_arr);
		$server_name=$name_arr[0];
		return $server_name;
	}
	$all_model = AbstractPressModel::all_models();
	foreach($all_model as $model)
	{
		$model_row = new ModelRow();
		$model_row->add_column($model->getProtocolType());
		$model_row->add_column($model->getToolName());
		$model_row->add_column(getServerName($model->getPressServer()));
		$model_row->add_column($model->getPressArgs());
		$model_row->add_tool_args_row($model->getToolArgs());
		$model_row->add_column($model->getPressModel());
		$model_row->add_hyper_column($model->getId(),$model);
 		echo $model_row->render();
	}
?>
</tbody>
</table>
</div>
</body>
</html>
