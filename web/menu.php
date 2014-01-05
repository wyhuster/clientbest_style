<?php
error_reporting(0);
require_once('./inc/commen.php');

$timeNow = time();
$myTime  = new CMyTime();
$myTime->str_time = date("Y-m-d", $timeNow);
$myTime->strTime = date("Ymd", $timeNow);
$myTime->nTime   = $timeNow;

$nodelist = new CNodeList();
$nodelist->init();

$iItemCount = 0;

//Vendor('FtpUpload.FtpUpload');
?>

<html><head>
<title>测试平台</title>
<meta http-equiv=Content-Type content="text/html; charset=utf-8">
<meta http-equiv=html content=no-cache>
<link href="./img/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="./img/js.js"></script>
</head>


<body bgcolor="#FAFCFF">

<table width=100% height=100% cellpadding=2 cellspacing=0 border=0>  
	  <tr><td valign="top" align=left>
		
				<table width=98%>  
			<a  href="./intro.php" style="font-weight:bolder;"  target=window_main>稳定性测试</a>
			<td id=submenuboarda>
			<table cellSpacing=0 cellPadding=0 width=100% align=left>  
				<td id=submenuboarda>
						<table cellSpacing=0 cellPadding=0 width=98% align=center>    
							<tr> 	  	
								<td class=tablebodyaa1 width=15 background=img/i.png></td>
								<td class=tablebodyaa1 vAlign=top>
								<img src="img/Tminus.png" align=absMiddle border=0>
								<a href="./st_conf/conf.php" target=window_main>测试部署</a>
								</td>
							</tr>

                            <tr>        
                                <td class=tablebodyaa1 width=15 background=img/i.png></td>
                                <td class=tablebodyaa1 vAlign=top>
                                <img src="img/Tminus.png" align=absMiddle border=0>
                                <a href="./st_monitor/monitor.php" target=window_main>测试监控</a>
                                </td>   
                            </tr> 

                            <tr>
                                <td class=tablebodyaa1 width=15 background=img/i.png></td>
                                <td class=tablebodyaa1 vAlign=top>
                                <img src="img/Tminus.png" align=absMiddle border=0>
                                <a href="./st_data/data_show.php" target=window_main>数据回放</a>
                                </td>
                            </tr>

							<tr> 	  	
								<td class=tablebodyaa1 width=15 background=img/i.png></td>
								<td class=tablebodyaa1 vAlign=top>
								<img src="img/Tminus.png" align=absMiddle border=0>
								<a href="./st_history/history.php" target=window_main>使用记录</a>
								</td>
							</tr>
							
							<tr>        
                                <td class=tablebodyaa1 width=15 background=img/i.png></td>
                                <td class=tablebodyaa1 vAlign=top>
                                <img src="img/Tminus.png" align=absMiddle border=0>
                                <a href="./st_ocean/ocean.php" target=window_main>ocean监控</a>
                                </td>   
                            </tr>   				
						</table>
					</td>           
			</table>  
			</table> 
	    </td></tr>
		<tr><td valign="top" align=left>
		</td></tr>
	</table>
</body>

</html>

