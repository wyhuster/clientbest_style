function showsubmenu(ss,ii,aa,openimg,closeimg)
{
	var menuobjedt=document.getElementById(ss);
	if (menuobjedt)
	{
	 if (menuobjedt.style.display=="none") 
	  {
		menuobjedt.style.display="";
	    document.getElementById(ii).src="img/nofollow.gif";
	    document.getElementById(ii).alt="关闭菜单";
	    document.getElementById(aa).src="img/"+openimg;
	    document.getElementById(aa).alt="关闭菜单";
	  }
	 else
	  { menuobjedt.style.display="none"; 
		document.getElementById(ii).src="img/plus.gif";
		document.getElementById(ii).alt="展开菜单";
		document.getElementById(aa).src="img/"+closeimg;
		document.getElementById(aa).alt="展开菜单";
	   }
	}
}
function showsubmenu_trace(ss,ii,aa,openimg,closeimg)
{
	var menuobjedt=document.getElementById(ss);
	if (menuobjedt)
	{
	 if (menuobjedt.style.display=="none") 
	  {
		menuobjedt.style.display="";
	    document.getElementById(ii).src="../img/plus.gif";
	    document.getElementById(ii).alt="关闭菜单";
	    document.getElementById(aa).src="img/"+openimg;
	    document.getElementById(aa).alt="关闭菜单";
	  }
	 else
	  { menuobjedt.style.display="none"; 
		document.getElementById(ii).src="../img/nofollow.gif";
		document.getElementById(ii).alt="展开菜单";
		document.getElementById(aa).src="img/"+closeimg;
		document.getElementById(aa).alt="展开菜单";
	   }
	}
}
function reloadpage()
{
	parent.window_left.location.reload();
}

function checkAddUser()
{
	var f1=document.form1;
	if(f1.username.value.length<1)
	{
		//alert("用户名不能为空！");
		f1.username.focus();
		return false;
	}
	else if(f1.realname.value.length<1)
	{
		//alert("真实姓名不能为空！");
		f1.realname.focus();
		return false;
	}
	else return true;
}

function opensetwin(url, winName, width, height,scroll)
{
	if(winName==null||winName=='')winName="123";
	winName=winName+""+new Date().getSeconds(); 
	//alert(new Date().getSeconds());
	if(typeof scroll=="undefined") scroll="0";
	xposition=0; yposition=0;
	if ((parseInt(navigator.appVersion) >= 4 ))
	{
		xposition = (screen.width - width) / 2;
		yposition = (screen.height - height) / 2;
	}
	theproperty= "width=" + width + ","
	+ "status:0,"
	+ "height=" + height + ","
	+ "location=0,"
	+ "menubar=0,"
	+ "resizable=1,"
	+ "scrollbars="+scroll+","
	+ "titlebar=0,"
	+ "toolbar=0,"
	+ "hotkeys=0,"
	+ "screenx=" + xposition + "," //仅适用于Netscape
	+ "screeny=" + yposition + "," //仅适用于Netscape
	+ "left=" + xposition + "," //IE
	+ "top=" + yposition; //IE
	//alert(theproperty);

	return window.open(url,winName,theproperty );
}

function del(id,key) 
{ 
	//alert(key);
	flag=confirm(' 确定要删除吗? \n\n 注意: 删除后不可恢复，请慎重!'); 
	if(flag) 
	{ 
		document.form1.key_btn.value = key;
		document.form1.delid.value = id;
		return true;
	}
	else return false;
}

function showsub(cid)
{
 var c=new Array();
 for(var k=1;k<4;k++)
 {	
	c[k]=document.getElementById("c" + k);
	  if(k==cid){
		c[cid].style.display="block";
    } 
    else {
	  c[k].style.display="none";
    }
 }
}

function dosubmit()
{
	var f1=document.form1;
	f1.action="main.php?op=ImportAdd";
	f1.submit();
}

function dosubmit2()
{
	var f1=document.Loform;
	f1.action="loadd.php";
	f1.submit();
}
function AddStatName()           
{                  
	 document.getElementById('statName').innerText = "继续添加统计项目";
	 tb = document.getElementById('statNames'); 
	 newRow = tb.insertRow();
	 newRow.insertCell().innerHTML = "<input name='statname[]'  type='text' size=30>&nbsp;&nbsp;&nbsp;<input type='text' name='Memo[]'"; 
} 
function checkboxselect(itemname,checkstatus) 
{
	//alert("checkboxselect"+document.getElementById('checkList').getElementsByTagName('input').length);

	if(!itemname) 
		return;
	if(!itemname.length) 
	{
		itemname.checked=checkstatus;
	} 
	else 
	{
		for(var i=0;i<itemname.length;i++) 
		{
			itemname[i].checked=checkstatus;
		}	
	}
}
function validcheck(alertcnt) 
{
	alert(alertcnt);
}
