<?php
	require_once("/home/work/renm/apache/apache2/htdocs/clientbest/web/tools/tool.php");


class LoaderTool extends AbstractTool{
	private $config_filename ="";//压力工具生成的配置文件目录
	
	private $use_loader=false;

	public function  getCfgFilename(){
		return $this->config_filename;
	}

	protected function makeCfgfile(){
		$this->config_filename ="/home/work/renm/apache/apache2/htdocs/clientbest/web/tools"."/../../configfiles/".$this->getID(".".$this->name);
	}

	function __construct(){
		$this->name = "loader_control";
	}
	function parseConfig($args)
	{

		$loader = $_POST['loader_control'];
		if($loader == "yes"){
			$this->use_loader = true;
			$this->server = $_POST['server_name'];

			$cpupercent = $_POST['cpupercent'];
			$memusage = $_POST['memusage'];
			$this->args['cpu_percent'] = $cpupercent;
			$this->args['mem_usage'] = $memusage;
		}

	}

	function generateConfig($thrad_nums)
	{
		if(!$this->use_loader) return;
		$this->makeCfgfile();

		$fp = fopen($this->config_filename,"w+");
		foreach($this->args as $key => $value)
		{
			fwrite($fp,$key."=\"".$value."\"\n");
		}
		fclose($fp);	

	}

	function saveConfig()
	{
	
		if(!$this->use_loader) return;
	}
	function execute()
	{

		if(!$this->use_loader) return;
		$curdir = "/home/work/renm/apache/apache2/htdocs/clientbest/web/tools";
		$cmd = "sh ".$curdir."/../../tools/copyandexeloader.sh ".$this->config_filename."  ".$this->server;#." >/dev/null & ";

		echo "<hr>";
		echo "部署负载控制工具...<br>";
		echo $cmd."<br>";
		$floader = popen($cmd,"r");
		pclose($floader);

	}

	function show()
	{
		echo "是否使用负载控制工具：";
		if($this->use_loader == false){
			echo "不使用<br>";
			return;
		} 
		echo "使用<br>";
		parent::show();
		foreach($this->args as $key => $value)
		{
			echo $key."=------".$value."<br>";
		}
	}

}
?>
