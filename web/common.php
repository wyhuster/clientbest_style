<?php
	ini_set("display_errors","ON");
	error_reporting(E_WARNING | E_NOTICE|E_ERROR);
	$root_path='/home/work/renm/apache/apache2/htdocs/clientbest/web';
	require_once($root_path.'/config.php');	
	require_once($root_path."/tools/factory.php");
	
	session_start();
	if(!session_is_registered('press_id'))
		$_SESSION['press_id'] = -1;
	#else echo "press_id".$_SESSION['press_id'];

	//返回NULL 说明没有测试在运行，否则，返回一个model
	function running_model()
	{
		if(!session_is_registered('press_id') || $_SESSION['press_id'] == -1)
		{
			return NULL;
		}
		$id = $_SESSION['press_id'];

		$model = AbstractPressModel::reload($id);
		if(!$model) {
			$_SESSION['press_id'] = -1;
			return NULL;
		}

		if($model->isRunning()) 
			return $model;

		$_SESSION['press_id'] = -1;
		return NULL;		
	}
class timer { 
	var $StartTime = 0; 
	var $StopTime = 0; 
	var $TimeSpent = 0; 

	function start()
	{ 
		$this->StartTime = microtime(); 
	} 

	function stop()
	{ 
		$this->StopTime = microtime(); 
	} 

	function spent() 
	{ 
		if ($this->TimeSpent) { 
			return $this->TimeSpent; 
		} else { 
			$StartMicro = substr($this->StartTime,0,10); 
			$StartSecond = substr($this->StartTime,11,10); 
			$StopMicro = substr($this->StopTime,0,10); 
			$StopSecond = substr($this->StopTime,11,10); 
			$start = floatval($StartMicro) + $StartSecond; 
			$stop = floatval($StopMicro) + $StopSecond; 
			$this->TimeSpent = $stop - $start; 
			$this->TimeSpent = round($this->TimeSpent,8); 
			return $this->TimeSpent;
		}
	} // end function spent(); 

} //end class timer;

?>



