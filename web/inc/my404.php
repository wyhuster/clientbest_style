<?php
	require_once('./inc/commen.php');
	
  $timeIn  = $_GET['time'];
	$myTime  = new CMyTime();
	
	$myTime->strTime = date("Y-m-d", $timeIn);
?>

<html>
	<style>
		a {text-decoration: none}
		a img {border: 0px solid;padding:5px;}
		a:visited, a:active, a:hover, a:link {color:#FF5904;}
	</style>
	
	<script language="JavaScript" src="../js/charts.js"></script>
	
	<body style="background-color:#DEDEDE;font-family:Verdana;size:12;">
		
		<script>
			function showXML (url){
			var t = window.open(url, 'XML', 'width=600,height=400,toolbar=0,menubar=0,resizable=0,status=0,directories=0,location=0,scrollbars=1')
			}
		</script>
		
		<br><br><br><br><br><br><br><br>
		
		<center>
			<table cellpadding="10">
				<tr>
					<td>
						<h1>暂时还没有 <?php echo "[ $myTime->strTime ]"; ?> 的数据, 请耐心等待！</h1>
					</td>
					</tr>
					
				</table>
			</center>

	</body>
</html>