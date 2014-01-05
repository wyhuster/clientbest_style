<?php
require_once('/home/work/renm/apache/apache2/htdocs/clientbest/web/tools/presstools.php');
require_once('/home/work/renm/apache/apache2/htdocs/clientbest/web/tools/pressmodel.php');
require_once('/home/work/renm/apache/apache2/htdocs/clientbest/web/tools/loader.php');

class ToolFactory{

	static function getTool($tool)
	{
		switch($tool){
		case "loader":
			return new LoaderTool();
		case "curlpress":
			return new CurlpressTool();
		case "jase":
			return new JaseTool();

		default:
			return NULL;
			
		}
	}
}


class PressModelFactory{

	static function getModel($model){
		switch($model){
		case "hengding":
			return new HengdingModel();
		case "zhendang":
			return new ZhengdangModel();
		case "jieti":
			return new JietiModel();
		case "langyong":
			return new LangyongModel();
		default:
			$ret_result = NULL;
		}

	}	
}
?>
