
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

function backToList(host){
	window.location.href = "./pro_ocean.php?host=".concat(host);	
}

function update(op,host){
	var app;
	if(op == "add"){
		app = document.getElementById("input_app").value;
	}
	else{
		app = document.getElementById("label_app").innerHTML;
	}
	
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
    //alert(url);   
    request.onreadystatechange = function() {
        if (request.readyState == 4)
        {
            if(request.status == 200)
            {
                //alert(request.responseText);
                var res = request.responseText.split(":");
                if(res[0]=="0"){
                    alert(res[1]);
                    window.location.href = "./pro_ocean.php?host=".concat(host);
                }else{
                    alert(res[1]);
                }
            }
        }
    };
    var url=update_url.concat("?host=").concat(host).concat("&appName=").concat(app).concat("&endTime=").concat(endtime).concat("&account=").concat(account).concat("&password=").concat(passwd);
    request.open("GET", "submit_to_ocean.php?url=" + encodeURIComponent(url), true);
    request.send(null);	
}

function delete_app(host){
	op_app("delete",host);
}

function start(host){
	op_app("start",host);
}

function stop(host){
	op_app("stop",host);
}

function op_app(op,host){
	var app = document.getElementById("label_app").innerHTML;
    var account = document.getElementById("input_account").value;
    var passwd = document.getElementById("input_password").value;

    if(app==null||app==""){
        alert("请输入进程名或者进程号!");
        return;
    }
    request.onreadystatechange = function() {
        if (request.readyState == 4)
        {
            if(request.status == 200)
            {
                var res = request.responseText.split(":");
                if(res[0]=="0"){
                    alert(res[1]);
                    window.location.href = "./pro_ocean.php?host=".concat(host);
                }else{
                    alert(res[1]);
                }
            }
        }
    };

	var url;
	if(op=="delete"){
    	url=delete_url.concat("?host=").concat(host).concat("&appName=").concat(app).concat("&account=").concat(account).concat("&password=").concat(passwd);
	}else if(op=="start"){
		url=start_url.concat("?host=").concat(host).concat("&appName=").concat(app).concat("&account=").concat(account).concat("&password=").concat(passwd);
	}else if(op=="stop"){
		url=stop_url.concat("?host=").concat(host).concat("&appName=").concat(app).concat("&account=").concat(account).concat("&password=").concat(passwd);
	}
	
	request.open("GET", "submit_to_ocean.php?url=" + encodeURIComponent(url), true);
    request.send(null);
}
