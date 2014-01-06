
//var update_url = "http://ocean.baidu.com/realtime/newAppMon/?host=".$host."&appName=java&account=work&endTime=20121009150000&password=www";
//var start_url = "http://ocean.baidu.com/realtime/turnOn/?host=".$host."&appName=java&account=work&password=www";
//var stop_url = "http://ocean.baidu.com/realtime/turnOff/?host=".$host."&appName=java&account=work&password=www";
//var delete_url = "http://ocean.baidu.com/realtime/removeApp/?host=".$host."&appName=java&account=work&password=www";

var update_url = "http://ocean.baidu.com/realtime/newAppMon/";
var start_url = "http://ocean.baidu.com/realtime/turnOn/";
var stop_url = "http://ocean.baidu.com/realtime/turnOff/";
var delete_url = "http://ocean.baidu.com/realtime/removeApp/";


function makeHttpObject() {
	try {
		return new XMLHttpRequest();
	}catch (error) {}
	try {
		return new ActiveXObject("Msxml2.XMLHTTP");
	}catch (error) {}
	try {
		return new ActiveXObject("Microsoft.XMLHTTP");
	}catch (error) {}
	throw new Error("Could not create HTTP request object.");
}

var request = makeHttpObject();


function add(host){
	var app = document.getElementById("input_app").value;
	var endtime = document.getElementById("input_endtime").value;
	var account = document.getElementById("input_account").value;
	var passwd = document.getElementById("input_password").value;
	
	if(app==null||app==""){
		alert("请输入进程名或者进程号!");
		return;
	}
	if(endtime==null||endtime==""){
		alert("请输入监控结束时间!");
		return;
	}
	var url=update_url.concat("?host=").concat(host).concat("&appName=").concat(app).concat("&endTime=").concat(endtime).concat("&account=").concat(account).concat("&password=").concat(passwd);
	alert(url);
	//document.getElementById("input_password").value=url;
	
	request.onreadystatechange = function() {
		alert(request.readyState);
		if (request.readyState == 4)
		{
			if(request.status == 200)
			{
				alert("test");
				alert(request.responseText);
			}
		}
	};
	request.open("GET", url, true);
	request.send(null);
	
}


function update(host){}

function delete_app(host){}

function start(host){}

function stop(host){}
