<?php
    error_reporting(E_ALL);
    require_once('/home/work/renm/apache/apache2/htdocs/clientbest/web/common.php');
    require_once('/home/work/renm/apache/apache2/htdocs/clientbest/web/head.php');
    require_once('/home/work/renm/apache/apache2/htdocs/clientbest/web/st_conf/side_menu.php');
?>

<div id="content">
<div id="content-header">
  <div id="breadcrumb"> 
      <a href="../index.php" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> 
      <a href="" class="current">测试部署</a> 
  </div>
</div>
<div class="container-fluid">

<?php

	if(isset($_POST['stop_id'])){
		$id = $_POST['stop_id'];
    	if($id != NULL and $id != ""){ 
    		$model = AbstractPressModel::reload($id);
    		if($model){
    			$model->stop();
				sleep(1);
				echo "测试已停止!<br/>";
    		}
		}
	}

    $model = running_model();
    if($model){
        echo "<p align = center style='font-family:Arial;font-size:20px;padding-top:15px; font-weight:bolder;' >您部署的测试正在运行中...<p>";
        $model->show();
		echo "</div></div>";
		require_once('/home/work/renm/apache/apache2/htdocs/clientbest/web/foot.php');
        return;
    }

?>

  <div class="row-fluid">
    <div class="span10">
      <div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
          <h5>部署参数</h5>
        </div>
        <div class="widget-content nopadding">
          <form action="bushu.php" method="post" class="form-horizontal">
			<input name="test_type" id="test_type" type="hidden" value="http"/>
            <input name="test_tool" id="test_tool" type="hidden" value="curlpress"/>
           
            <div class="control-group">
              <label class="control-label">测试运行服务器 :</label>
              <div class="controls">
				<select id="run_server" class="span6" name="run_server" size="1">
                <option value="cp01-testing-bdcm05.cp01.baidu.com" selected=true>cp01-testing-bdcm05.cp01.baidu.com</option>
                <option value="cp01-testing-bdcm06.cp01.baidu.com">cp01-testing-bdcm06.cp01.baidu.com</option>
                <option value="cp01-testing-bdcm07.cp01.baidu.com">cp01-testing-bdcm07.cp01.baidu.com</option>
                <option value="cp01-testing-bdcm08.cp01.baidu.com">cp01-testing-bdcm08.cp01.baidu.com</option>
                </select>
              </div>
            </div>
		   
		    <div class="control-group">
              <label class="control-label">被测服务主机名 :</label>
              <div class="controls">
                <input type="text" id="server_name" name="server_name" class="span6" />
                <span class="help-block">*ocean资源查看需要主机名</span> </div>
            </div>

            <div class="control-group">
              <label class="control-label">请求方式 :</label>
              <div class="controls">
				  <input type="radio" name="request_method" value="GET" checked onclick='showPostData(false)'>Get&nbsp;&nbsp;&nbsp;</input>
				  <input type="radio" name="request_method" value="POST" onclick='showPostData(true)'>Post</input>
              </div>
            </div>
		   
            <div class="control-group">
              <label class="control-label">url :</label>
              <div class="controls">
                <input id="request_url" name="request_url" type="text" class="span6" value="" />
              </div>
            </div>
		   
            <div class="control-group" id="div_conf_data">
              <label class="control-label">post data :</label>
              <div class="controls">
                <textarea name="request_data" type="text" class="span6" value=""></textarea>
              </div>
            </div>
		   
            <div class="control-group">
              <label class="control-label">cookie :</label>
              <div class="controls">
                <input name="request_cookie" type="text" class="span6" value=""/>
              </div>
            </div>
            
            <div class="control-group">
              <label class="control-label">压力模型 :</label>
              <div class="controls">
                <select name="press_model" id="press_model" class="span6" onchange="change_press_model(this)">
                <option value="hengding" selected=true>恒定</option>
                <option value="jieti" >阶梯</option>
                <option value="zhendang" >震荡</option>
                <option value="langyong" >浪涌</option>
                </select>
              </div>
            </div>
			
			<div id = "press_model_args"></div>

            <div class="form-actions">
              <button type="submit" class="btn btn-success" onclick="return checkArgs()">部署</button>
            </div>
          </form>
        </div>
      </div>
   </div>
</div>
</div>
</div>



<div id="press_model_hending" style="display:none" >
   <div class="control-group">
     <label class="control-label">qps :</label>
     <div class="controls">
       <input name="qps" type="text" class="span6" onkeyup="onlynum(this)" onafterpaste="onlynum(this)"/>
     </div>
   </div>
   <div class="control-group">
     <label class="control-label">时间(min) :</label>
     <div class="controls">
       <input name="time" type="text" class="span6" onkeyup="onlynum(this)" onafterpaste="onlynum(this)"/>
     </div>
   </div>
</div>


<div id="press_model_jieti" style="display:none">
   <div class="control-group">
     <label class="control-label">开始qps :</label>
     <div class="controls">
       <input name="qps_start" type="text" class="span6" onkeyup="onlynum(this)" onafterpaste="onlynum(this)"/>
     </div>
   </div>
   <div class="control-group">
     <label class="control-label">结束qps :</label>
     <div class="controls">
       <input name="qps_end" type="text" class="span6" onkeyup="onlynum(this)" onafterpaste="onlynum(this)"/>
     </div>
   </div>
   <div class="control-group">
     <label class="control-label">qps间隔 :</label>
     <div class="controls">
       <input name="qps_interval" type="text" class="span6" onkeyup="onlynum(this)" onafterpaste="onlynum(this)"/>
     </div>
   </div>
   <div class="control-group">
     <label class="control-label">每qps压力时间(min) :</label>
     <div class="controls">
       <input name="time_interval" type="text" class="span6" onkeyup="onlynum(this)" onafterpaste="onlynum(this)"/>
     </div>
   </div>
</div>

<div id="press_model_langyong" style="display:none">
   <div class="control-group">
     <label class="control-label">最低qps :</label>
     <div class="controls">
       <input name="low_qps" type="text" class="span6" onkeyup="onlynum(this)" onafterpaste="onlynum(this)"/>
     </div>
   </div>
   <div class="control-group">
     <label class="control-label">最高qps :</label>
     <div class="controls">
       <input name="high_qps" type="text" class="span6" onkeyup="onlynum(this)" onafterpaste="onlynum(this)"/>
     </div>
   </div>
   <div class="control-group">
     <label class="control-label">时间间隔(min) :</label>
     <div class="controls">
       <input name="time_interval" type="text" class="span6" onkeyup="onlynum(this)" onafterpaste="onlynum(this)"/>
     </div>
   </div>
   <div class="control-group">
     <label class="control-label">时间(min) :</label>
     <div class="controls">
       <input name="time" type="text" class="span6" onkeyup="onlynum(this)" onafterpaste="onlynum(this)"/>
     </div>
   </div>
</div>


<div id="press_model_zhengdang" style="display:none">
   <div class="control-group">
     <label class="control-label">最低qps :</label>
     <div class="controls">
       <input name="low_qps" type="text" class="span6" onkeyup="onlynum(this)" onafterpaste="onlynum(this)"/>
     </div>
   </div>
   <div class="control-group">
     <label class="control-label">最高qps :</label>
     <div class="controls">
       <input name="high_qps" type="text" class="span6" onkeyup="onlynum(this)" onafterpaste="onlynum(this)"/>
     </div>
   </div>
   <div class="control-group">
     <label class="control-label">时间(min) :</label>
     <div class="controls">
       <input name="time" type="text" class="span6" onkeyup="onlynum(this)" onafterpaste="onlynum(this)"/>
     </div>
   </div>
</div>

<script type="text/javascript" src="./conf.js"></script>
<script type="text/Javascript">
    window.onload=load;
</script>
<?php
    require_once('/home/work/renm/apache/apache2/htdocs/clientbest/web/foot.php');
?>
