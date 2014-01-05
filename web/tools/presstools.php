<?php
	require_once('/home/work/renm/apache/apache2/htdocs/clientbest/web/common.php');
	require_once('/home/work/renm/apache/apache2/htdocs/clientbest/web/tools/factory.php');
	require_once('/home/work/renm/apache/apache2/htdocs/clientbest/web/tools/tool.php');


abstract class AbstractPressTool extends AbstractTool{
	protected $config_filedir ="";//压力工具生成的配置文件目录
	protected $args = array();

	public function reload($config_file,$server,$args)
	{
		$this->config_filedir = $config_file;
		$this->server = $server;
		$this->args = $args;
		
		//从生成的文件中读取参数信息
		$this->reloadSpecial();
	}

	public function monitor($id)
	{
		return $this->doMonitor($id);
	}
	public function  getCfgDir(){
		return $this->config_filedir;
	}

	public function  parseConfig($args)
	{
		$this->server = $args['run_server'];//运行服务器
		$this->args['server']=$args['server_name'];//被测服务器
		$this->doParseConfig($args);	
	}

	protected function makeCfgDir(){
		$this->config_filedir = "/home/work/renm/apache/apache2/htdocs/clientbest/configfiles/".$this->getID(".".$this->name);
#		echo $this->config_filedir;
		mkdir($this->config_filedir);
	}

	public function show()
	{
		parent::show();	
	//	print_r(each($this->args));
		foreach($this->args as $key=>$value)
		{
			#echo "<xmp>".$key." = ".$value."</xmp>";
			echo $key."=".htmlspecialchars($value)."<br>";
		}
	}

	function execute()
	{
		global $db;
		$sql = "select max(id) from history_record";
		$result = mysql_query($sql);
		$rows = mysql_fetch_array($result);
		$id_history = $rows[0];
		mysql_free_result($result);
		
		$curdir = "/home/work/renm/apache/apache2/htdocs/clientbest";
		$cmd = "sh ".$curdir."/tools/copyandexepress.sh ".$this->config_filedir."  ".$this->server."  ".$id_history;#." >/dev/null &";

		echo "<hr>";
		echo "测试部署中...<br>";
		echo $cmd."<br>";
 		$fpress = popen($cmd,"r");
		pclose($fpress);

	}


	function saveConfig(){}
	abstract protected function doParseConfig($args);
	abstract protected function reloadSpecial();
	abstract protected function doMonitor($id);
}




class CurlpressTool extends  AbstractPressTool{
	
	function __construct(){
		$this->name = "curlpress";
	}

	protected function doParseConfig($args)
	{
			$this->args['type'] = $args['request_method'];
			$this->args['url'] = $args['request_url'];
			if(isset($args['request_data']) && $args['request_data'] != ""){
				$this->args['data'] = $args['request_data'];
			}
			if(isset($args['request_cookie']) && $args['request_cookie'] != ""){
				$this->args['cookie'] = $args['request_cookie'];
			}
	}

	function generateConfig($thread_nums)
	{
		$result = array();
		$this->makeCfgDir();
		$tool_args['url']= $this->args['url'];	
		$tool_args['type']= $this->args['type'];	

		$filedir = strrchr($this->config_filedir,'/');
		
		if(isset($this->args['data']) && $this->args['data'] != ""){
			$fp = fopen($this->config_filedir."/data","w+");
			fwrite($fp,$this->args['data']);
			fclose($fp);	
			$tool_args['data'] = "<".self::WORK_PATH."data".$filedir."/data";
		}

		if(isset($this->args['cookie']) && $this->args['cookie'] != ""){
			$fp = fopen($this->config_filedir."/cookie","w+");
			fwrite($fp,$this->args['cookie']);
			fclose($fp);	
			$tool_args['cookie'] = "<".self::WORK_PATH."data".$filedir."/cookie";
		}

		$result['tool_args']=$tool_args;
		$result['config_filedir'] = $this->config_filedir;
		return $result;
	}

	function reloadSpecial()
	{
	
		$data_file = $this->config_filedir."/data";	
		if(file_exists($data_file)) 
			$this->args['data']=file_get_contents($data_file);

		$cookie_file = $this->config_filedir."/cookie";	
		if(file_exists($cookie_file)) 
			$this->args['cookie']=file_get_contents($cookie_file);
	}

	function doMonitor($id)
	{
		$time = new timer();
		$ch = curl_init();
		
		curl_setopt($ch,CURLOPT_URL,$this->args['url']);
		curl_setopt($ch,CURLOPT_HEADER, 1);	
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		
		//post
		if($this->args['type'] == 'POST' && $this->args['data'] != NULL){
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $this->args['data']);
		}
		
		//cookie
		if(isset($this->args['cookie']) && $this->args['cookie'] != NULL){
			curl_setopt($ch, CURLOPT_COOKIE, $this->args['cookie']);
		}		
		
		$time->start();
		$res_content = curl_exec($ch);		
		$time->stop();
		
		//$curl_close($ch);
		global $db;
		$max_time = $time->spent();
		$sql = "select * from history_record where data_id = $id order by time desc limit 1";
		$result = mysql_query($sql,$db);
		if($result){
			$row = mysql_fetch_array($result);	
			if($row != NULL && $max_time < $row['max_time']){
				$max_time = $row['max_time'];	
			}else{
				$update_sql = "update history_record set max_time='".$max_time."' where id=".$row['id'];
				mysql_query($update_sql,$db);
			}	
		}
		echo "最大响应时间：".$max_time."秒<br>";
		echo "当前响应时间：".$time->spent()."秒";
		echo "<br>返回内容<br>";
		#echo "<xmp>".$res_content."</xmp>";
		echo "<br>".$res_content."<br>";
	}	
}


class JaseTool extends  AbstractPressTool{
	
	function __construct(){
		$this->name = "jase";
	}

	protected function doParseConfig($args)
	{
			$this->args['user_type'] = $args['user_type'];
			$this->args['port'] = $args['port'];
			$this->args['data'] = $args['request_data'];

	}

	function generateConfig($thread_nums)
	{
		$result = array();
		$this->makeCfgDir();

		$tool_args['user_type'] = $this->args['user_type'];
		$tool_args['port'] = $this->args['port'];
		$tool_args['server']=$this->args['server'];

		$fp = fopen($this->config_filedir."/jase.xml","w+");
		fwrite($fp,$this->args['data']);
		fclose($fp);	

		$result['tool_args']=$tool_args;
		$result['config_filedir'] = $this->config_filedir;
		return $result;
	}


	function reloadSpecial()
	{
		$xml_file = $this->config_filedir."/jase.xml";	
		$this->args['data']=file_get_contents($xml_file);
	}

	function doMonitor($id)
	{
	}


}
?>
