<?php
	require_once('/home/work/renm/apache/apache2/htdocs/clientbest/web/tools/factory.php');
	require_once('/home/work/renm/apache/apache2/htdocs/clientbest/web/config.php');
	require_once('/home/work/renm/apache/apache2/htdocs/clientbest/web/tools/tool.php');

interface PressModel{

	function parseArgs($args);
	function generateConfig();
	function show();
	function isRunning();
	function stop();
	function monitor();
	static function reload($id);
	function execute();
	function save();
}	

abstract class AbstractPressModel implements PressModel{
	protected $name="";//压力模型，中文
	protected $tag="";//压力模型
	protected $protocol_type="";//压力工具类型
	protected $module_name="";//模块所在服务器
	protected $press_server="";//压力工具运行服务器
	protected $args = array(); //press_mode参数
	protected $toolname = "";//压力工具名称
	protected $tool_content = array();//press_tool参数
	protected $desc="无";
	protected $tool = NULL;
	protected $id = -1;
	protected $histoty_id = -1;
	protected $info = "";//shuoming
	protected $usetime = "";//shuoming
	protected $update_time = "" ;//历史记录时间
	protected $running = 0;//当前测试是否在运行
	protected $pid = "";


	public function getPid()
	{
		return $this->pid;
	}
	public function getId()
	{
		return $this->histoty_id;
	}
	public function getUpdatetime()
	{
		return $this->update_time;
	}
	public function getUseTime()
	{
		return $this->usetime;
	}
	public function getInfo()
	{
		return $this->info;
	}
	public function getPressModel()
	{
		return $this->name;
	}
	public function getToolName()
	{
		return $this->toolname;
	}
	public function getProtocolType()
	{
		return $this->protocol_type;
	}
	public function getModuleName()
	{
		return $this->module_name;
	}
	public function getPressServer()
	{
		return $this->press_server;
	}
	public function getPressArgs()
	{
		$content="";
		foreach($this->args as $key=>$value)
		{
		  $content .=  $key." = ".$value."<br>";
		}
		return $content;
	}
	public function getToolArgs()
	{
		return $this->tool_content;
		/*$conf_file=$this->tool_content['config_filedir'];
		$conf_file_arr=explode("/",$conf_file);
		$length_conf_file=sizeof($conf_file_arr);
		$index = $length_conf_file-1;
		return $conf_file_arr[$index];
		*/
	}
	public function getBinServer()
	{
		return $this->module_name;
	}
	protected static function reloadByDbRow($row)
	{
		$model = NULL;

		if(!is_array($row) || count($row) == 0) return NULL;

		$press_mode = explode('|',$row['press_mode']);	
		$press_name = $press_mode[0];
                $press_chines_name = $press_mode[1];
		$model = PressModelFactory::getModel($press_name);	
		if(!$model){
			return NULL;
		}
		
		$model->running = $row['running'];
		$model->info = $row['descinfo'];
		$model->usetime = $row['last_time'];
		//$model->update_time = $row['time'];
		$model->id = $row['id'];
		$model->histoty_id = $row['id'];
		
		$model->args = json_decode($row['press_args'],true);
		$model->toolname = $row['tool_name'];
		$model->protocol_type = $row['type'];
		$model->tool_content= json_decode($row['tool_args'],true);
		if(isset($model->tool_content['server']))
			 $model->module_name = $model->tool_content['server'];
		$model->press_server = $row['press_server'];	
		/*reset($model->tool_content);
		while(list($key,$val) = each($model->tool_content))
		{
			print_r( "$key => $val<br/>");
		}*/
		$model->tool = ToolFactory::getTool($model->toolname);	
		$model->tool->reload($model->tool_content['config_filedir'],$model->press_server,$model->tool_content['tool_args']);
		
		return $model;
		
	}

	protected static function reloadByDbRowHistory($row)
	{
		$model = NULL;

		if(!is_array($row) || count($row) == 0) return NULL;

		$press_mode = explode('|',$row['press_mode']);	
		$press_name = $press_mode[0];
                $press_chines_name = $press_mode[1];
		$model = PressModelFactory::getModel($press_name);	
		if(!$model){
			return NULL;
		}
        $model->info = $row['desc_info'];
        $model->pid = $row['pid'];
		$model->update_time = $row['time']."--".$row['stop_time'];
		$model->id = $row['id'];
		$model->histoty_id = $row['id'];
		$model->args = json_decode($row['press_args'],true);
		$model->toolname = $row['tool_name'];
		$model->protocol_type = $row['type'];
		$model->tool_content= json_decode($row['tool_args'],true);
		if(isset($model->tool_content['server']))
			 $model->module_name = $model->tool_content['server'];
		$model->press_server = $row['press_server'];	
		/*reset($model->tool_content);
		while(list($key,$val) = each($model->tool_content))
		{
			print_r( "$key => $val<br/>");
		}*/
		$model->tool = ToolFactory::getTool($model->toolname);	
		$model->tool->reload($model->tool_content['config_filedir'],$model->press_server,$model->tool_content['tool_args']);
		
		return $model;
		
	}
	
	public static function reload($id)
	{
		global $db;
		$modle = NULL;
		$sql = "select * from data_playback where id = $id";
		$result = mysql_query($sql,$db);
		if(!$result){
			echo $sql." 查询失败\n";
			return;
		}
		$row = mysql_fetch_array($result);
		if(count($row) == 0){
		  echo "id $id 在数据库中不存在\n";
		  return;
		}
		while($row){
			$model = AbstractPressModel::reloadByDbRow($row);
			//设置id，说明不是第一次使用了,save的时候会根据这个判断
			if($model) $model->id = $id;
			break;//只应该有一行
		}
		
		mysql_free_result($result);
		return $model;
	}
       
        public static function all_models()
        {
               global $db; 
               $sql = "select * from data_playback order by last_time desc";
	       $result = mysql_query($sql,$db);
	       $all_models = array();
               if(!$result)
               {
                 echo $sql."query mysql failed!";
                 return;
               }
               $row = mysql_fetch_array($result);
               if(count($row) == 0){
                echo "no data in database!";
		return;
               }
               while($row){
		$model = AbstractPressModel::reloadByDbRow($row);
		array_push($all_models, $model);
		$row = mysql_fetch_array($result);
               }
	       mysql_free_result($result);
	       return $all_models;
        }
        public static function all_history_models()
        {
               global $db; 
               $sql = "select history_record.id,history_record.desc_info,history_record.pid,history_record.time,history_record.stop_time,data_playback.type,data_playback.module_server,data_playback.press_server,data_playback.press_mode,data_playback.press_args,data_playback.tool_name,data_playback.tool_args from history_record,data_playback where history_record.data_id=data_playback.id order by history_record.id desc";
	       $result = mysql_query($sql,$db);
	       $all_models = array();
               if(!$result)
               {
                 echo $sql."query mysql failed!";
                 return;
               }
               $row = mysql_fetch_array($result);
               if(count($row) == 0){
                echo "no data in database!";
		return;
               }
               while($row){
		$model = AbstractPressModel::reloadByDbRowHistory($row);
		array_push($all_models, $model);
		$row = mysql_fetch_array($result);
               }
	       mysql_free_result($result);
	       return $all_models;
        }


	public function save()
	{
		global $db;
		$press_mode=$this->tag."|".$this->name;
		$press_args = json_encode($this->args);
		$tool_content = json_encode($this->tool_content);
		if($this->id == -1) {//id 为-1表明是第一次创建，插入data表
			$data_sql = "insert into data_playback (type,module_server,press_server,press_mode,press_args,tool_name,tool_args,descinfo) 
					values('$this->protocol_type','$this->module_name','$this->press_server','$press_mode','$press_args',
						'$this->toolname','$tool_content','$this->desc')";
		}else{//说明是reload，回放，更新时间
			$data_sql = "update data_playback set last_time = NOW(),running = true where id = $this->id";	
		}
		
		if(!mysql_query($data_sql,$db)){
			echo $data_sql." 查询失败\n";
			$errstr = mysql_error();
			echo $errstr;
			return;
		}else{
			if($this->id == -1)
				$this->id = mysql_insert_id();
		}
		$history_sql = "insert into history_record (data_id,desc_info) values($this->id,'$this->desc')";
		if(!mysql_query($history_sql,$db)){
			echo $history_sql." 查询失败\n";
			$errstr = mysql_error();
			echo $errstr;
			return;
		}else{
			$get_current_id = "select max(id) from history_record";
			$result = mysql_query($get_current_id,$db);
			$row = mysql_fetch_array($result);
			$this->histoty_id = $row[0];
			mysql_free_result($result);
		}
	}
	function parseArgs($args)
	{
		$this->protocol_type = $args['test_type'];
		$this->toolname = $args['test_tool'];
		$this->module_name = $args['server_name'];
		$this->press_server = $args['run_server'];
		if(isset($args['desc']) && $args['desc'] != NULL)
			$this->desc = $args['desc'];

		$this->doParseArgs($args);	

		$this->tool = ToolFactory::getTool($this->toolname);	
		$this->tool->parseConfig($args);
	}

	function generateConfig()
	{
        
		$this->tool_content = $this->tool->generateConfig(0);
		$dir = $this->tool_content['config_filedir'];
		$tool_args = $this->tool_content['tool_args'];
		
		$fp = fopen($dir."/press.conf","w+");
		
		fwrite($fp,"[mode]\n");
		$filedir = strrchr($dir,'/');
		fwrite($fp,"mode=".$this->tag."\n");
		fwrite($fp,"tool_path=".Tool::WORK_PATH."tools/\n");
		fwrite($fp,"case_path=".Tool::WORK_PATH."data".$filedir."/\n");
		fwrite($fp,"tool=".$this->tool->getName()."\n");

		//具体模型的配置
		fwrite($fp,"[".$this->tag."]\n");
		foreach($this->args as $key => $value)
		{
			fwrite($fp,$key."=".$value."\n");
		}

		//工具所使用的参数
		fwrite($fp,"[".$this->tool->getName()."]\n");
		foreach($tool_args as $name => $value)
		{
			fwrite($fp,$name."=".$value."\n");
		}
		fclose($fp);	
	}
	
	function isRunning()
	{
		if($this->running == 0)
			return false;
		$filedir = $this->tool_content['config_filedir'];
		$name = $filedir."/python.pid";

		if(!file_exists($name)) 
			return false;
		$pid = file_get_contents($name);	
		if(!$pid) return false;
		$curdir = "/home/work/renm/apache/apache2/htdocs/clientbest/web/tools";	
		$cmd = "sh ".$curdir."/../../tools/is_press_running.sh ".$pid." ".$this->press_server;
		$result = exec($cmd);
		if($result >=1) return true;
		return false;
	}
	
	function stop(){
	
		
		global $db;
		$data_sql = "update data_playback set running = 0 where id = $this->id";	

		if(!mysql_query($data_sql,$db)){
			echo $data_sql." 更新失败\n";
			$errstr = mysql_error();
			echo $errstr;
			//return;
		}

		$filedir = $this->tool_content['config_filedir'];
		$name = $filedir."/python.pid";

		if(!file_exists($name)) 
			return;
		$pid = file_get_contents($name);	
		if(!$pid) return;
		$curdir = "/home/work/renm/apache/apache2/htdocs/clientbest/web/tools";	
		$cmd = "sh ".$curdir."/../../tools/stop.sh ".$this->toolname." ".$pid." ".$this->press_server;
		exec($cmd);

		$this->running = 0;
	}
	
	function monitor()
	{
		$this->tool->monitor($this->id);
	}
	
	function show()
	{
		$this->tool->show();
		echo "压力模型：".$this->name."<br>";
		$content = "";
		foreach($this->args as $key => $value)
		{
			$content .=  $key." = ".$value."<br>";
		}
		echo $content;
		echo "<br><form action='/clientbest/web/st_conf/conf.php' method='post' target='_self'>";
		echo "<input type=hidden name=stop_id value=$this->id>";
		echo "<input type=submit value='停止' onclick=\"return confirm('你确定要停止该测试吗？停止后可在数据回放中选择回放')\"/>";
		echo "</form>";
	}
	function execute()
	{
		$this->save();	
		$this->tool->execute();
		$this->running = 1;

		//monitor when the press stop
		$filedir = $this->tool_content['config_filedir'];
		$name = $filedir."/python.pid";
		if(!file_exists($name)){
			//start press fail
			$data_sql = "update data_playback set running = 0 where id = ".$this->id;	
			return false;
		}
		$pid = file_get_contents($name);
		//add $pid to db
		global $db;
		$insert_pid = "update history_record set pid = ".$pid." where id = ".$this->histoty_id;
		mysql_query($insert_pid,$db);
		$base_path = "/home/work/renm/apache/apache2/htdocs/clientbest/web/tools";
		exec("php ".$base_path."/isRunning.php ".$pid." ".$this->press_server." ".$this->id." ".$this->histoty_id." >>".$base_path."/monitor.log 2>&1 &");
		
		return $this->id;	
	}

	abstract protected function doParseArgs($args);

}

class HengdingModel extends AbstractPressModel{


	function __construct(){
		$this->name = "恒定";
		$this->tag = "hengding";
	}


	protected function doParseArgs($args)
	{
		$this->args['qps'] = $args['qps'];
		$this->args['time'] =$args['time'];
	}

}


class JietiModel extends AbstractPressModel{


	function __construct(){
		$this->name = "阶梯";
		$this->tag = "jieti";
	}


	protected function doParseArgs($args)
	{
		$this->args['qps_start'] = $args['qps_start'];
		$this->args['qps_end'] = $args['qps_end'];
		$this->args['qps_interval'] = $args['qps_interval'];
		$this->args['time_interval'] = $args['time_interval'];
	}
	
}

class ZhengdangModel extends AbstractPressModel{


	function __construct(){
		$this->name = "震荡";
		$this->tag = "zhendang";
	}


	protected function doParseArgs($args)
	{

		$this->args['low_qps'] =$args['low_qps'];
		$this->args['high_qps'] =$args['high_qps'];
		$this->args['time'] =$args['time'];
	}
	
}

class LangyongModel extends AbstractPressModel{


	function __construct(){
		$this->name = "浪涌";
		$this->tag = "langyong";
	}


	protected function doParseArgs($args)
	{
		$this->args['low_qps'] = $args['low_qps'];
		$this->args['high_qps'] =$args['high_qps'];
		$this->args['time_interval'] = $args['time_interval'];
		$this->args['time'] =$args['time'];
	}
}

?>
