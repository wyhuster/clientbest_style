
<?php
ini_set("date.timezone","Asia/Shanghai");	
interface Tool{

	CONST WORK_PATH = "/home/work/clientbest/";
	function parseConfig($args);
	function generateConfig($thread_nums);
	function execute();
	function saveConfig();
	function show();
}

abstract class AbstractTool implements Tool{
	protected $name = "";
	protected $server = "";//工具运行的服务器

	public function  getName()
	{
		return $this->name;
	}	
	// 生成随机文件名
    protected  function getID($suffix) 
	{
	   //第一步:初始化种子 
	   //microtime(); 是个数组
	   $seedstr =split(" ",microtime(),5); 
	   $seed =$seedstr[0]*10000;   
	   //第二步:使用种子初始化随机数发生器 
	   srand($seed);   
	   //第三步:生成指定范围内的随机数 
		$random =rand(10,99);
		$filename = date("Y-m-d-H-i-s", time()).$random.$suffix;
		return $filename;
	}

	public function show()
	{
		echo "工具名称：".$this->name."<br>";
		echo "运行服务器: ".$this->server."<br>";
	}

}
?>
