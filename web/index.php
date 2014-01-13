<?php
	require_once("/home/work/renm/apache/apache2/htdocs/clientbest/web/head.php");
?>

<!--sidebar-menu-->
<div id="sidebar">
<!--<a href="#" class="visible-phone"><i class="icon icon-home"></i> Dashboard</a>-->
  <ul>
    <li class="active"><a href="/clientbest/web/index.php"><i class="icon icon-home"></i> <span>Index</span></a> </li>
    <li><a href="/clientbest/web/st_conf/conf.php"><i class="icon icon-signal"></i> <span>测试部署</span></a> </li>
    <li><a href="/clientbest/web/st_monitor/monitor.php"><i class="icon icon-inbox"></i> <span>测试监控</span></a> </li>
    <li><a href="/clientbest/web/st_data/data_show.php"><i class="icon icon-th"></i> <span>数据回放</span></a></li>
    <li><a href="/clientbest/web/st_history/history.php"><i class="icon icon-fullscreen"></i> <span>使用记录</span></a></li>
    <li><a href="/clientbest/web/st_ocean/ocean.php"><i class="icon icon-tint"></i> <span>ocean监控</span></a></li>
  </ul>
</div>
<!--sidebar-menu-->


<!--main-container-part-->
<div id="content">
<!--breadcrumbs-->
  <div id="content-header">
    <div id="breadcrumb"> <a href="index.php" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a></div>
  </div>
  <!--End-breadcrumbs-->
  <div class="container-fluid">
	<div class="clentbest-title">
        <h3>测试部署</h3> 
        <div class="clentbest-data">
        <p>部署你的测试</p>
        <p></p> 
        </div>  
    </div> 
	<hr/> 
    <div class="clientbest-title">
        <h3>测试监控</h3> 
        <div class="acc-data">
            <p>监视测试运行状况，查看response和log输出</p>
            <p></p> 
        </div>  
    </div>  
	<hr/> 
    <div class="clientbest-title">
        <h3>数据回放</h3> 
        <div class="acc-data">
            <p>从已有的测试配置数据重新运行测试</p>
            <p></p> 
        </div>  
    </div>  
	<hr/> 
    <div class="clientbest-title">
        <h3>使用记录</h3> 
        <div class="acc-data">
            <p>测试历史使用记录，测试报告查看</p>
            <p></p> 
        </div>  
    </div>  
	<hr/> 
    <div class="clientbest-title">
        <h3>ocean监控</h3> 
        <div class="acc-data">
            <p>测试过程中ocean机器资源和进程资源查看</p>
            <p></p> 
        </div>  
    </div>  
  </div>
</div>
<!--end-main-container-part-->

<?php
	require_once("/home/work/renm/apache/apache2/htdocs/clientbest/web/foot.php");
?>

