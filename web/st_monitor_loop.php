<?php
	require_once('/home/work/renm/apache/apache2/htdocs/clientbest/web/config.php');
	require_once('/home/work/renm/apache/apache2/htdocs/clientbest/web/tools/factory.php');
?>
<?php 
		global $db;
		while(1){
			
			$sql = "select id from data_playback where running = 1";
			
			$result = mysql_query($sql,$db);
			if(!$result)
				goto again;
			
			$row = mysql_fetch_array($result);
			while($row){
				
				$id = $row['id'];
				$model = AbstractPressModel::reload($id);

				if(!$model || !$model->isRunning()){//如果该测试没有运行，就更新数据库的running字段。
					$update_sql = "update data_playback set running = false where id = $id";
					
					$row=mysql_fetch_array($result);	

					mysql_query($update_sql,$db);
					continue;
				}
				
				$model->monitor();
				$row=mysql_fetch_array($result);	
				sleep(1);
			}

			mysql_free_result($result);	
		again:
			sleep(60);
		}
?>

