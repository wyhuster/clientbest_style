<?php
	
	header("Content-Type:text/html;charset=utf-8");
	
	function writeLog($file,$str,$mode='a') 
	{
		$uname=$_SESSION["name"];
		$ctime = date('Y-m-d H-i-s', time());
		$str = $ctime." user-".$uname." ".$str;	

		$oldmask = @umask(0); 
		$fp = @fopen($file,$mode); 
		@flock($fp, 3); 
		if(!$fp) 
		{ 
			Return false; 
		} 
		else 
		{ 
			@fwrite($fp,$str); 
			@fwrite($fp,"\n"); 
			@fclose($fp); 
			@umask($oldmask); 
			Return true; 
		} 
	} 




?>