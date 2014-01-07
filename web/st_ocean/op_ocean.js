//remove the time text begin and end empty
function getParentTime(id){
	var text = parent.document.getElementById(id).value;
	var textValue = text.replace(/(^\s*)|(\s*$)/g, "");
	if(textValue == null || textValue == "") {  
		return "";  
	}
	return textValue;
}


function viewOceanData(host,app){
	var starttime = getParentTime("start_date").replace(/[^0-9]/g,"");
	var endtime = getParentTime("end_date").replace(/[^0-9]/g,"");
	if(starttime == ""){
        alert("开始时间不能为空!");
        return;
    }
    if(endtime == ""){
        alert("结束时间不能为空!");
        return;
    }
    if((starttime-0)>(endtime-0)){
        alert("开始时间不能大于结束时间!");
        return;
    }	
	
	var query_url = "http://ocean.baidu.com/realtime/graph/?pn=3.2&begin=".concat(starttime).concat("&end=").concat(endtime).concat("&host=").concat(host).concat("&app=").concat(app); 
	
	window.open(query_url);
}





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


function backToList(host){
	window.location.href = "./pro_ocean.php?host=".concat(host);	
}

function update(op,host){
	var update_url = "http://ocean.baidu.com/realtime/newAppMon/";
	var app;
	
	if(op == "add"){
		app = document.getElementById("input_app").value;
	}
	else{
		app = document.getElementById("label_app").innerHTML;
	}
	
    var endtime = document.getElementById("input_endtime").value.replace(/[^0-9]/g,"");
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
	
	var request = makeHttpObject();
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
            }else{
				alert("network error!");
			}
			showLoading(false);
        }
    };
    var url=update_url.concat("?host=").concat(host).concat("&appName=").concat(app).concat("&endTime=").concat(endtime).concat("&account=").concat(account).concat("&password=").concat(passwd);
    request.open("GET", "submit_to_ocean.php?url=" + encodeURIComponent(url), true);
    request.send(null);	
	showLoading(true);
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
	var request = makeHttpObject();
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
            }else{
				alert("network error!");
			}
			showLoading(false);
        }
    };

	var start_url = "http://ocean.baidu.com/realtime/turnOn/";
	var stop_url = "http://ocean.baidu.com/realtime/turnOff/";
	var delete_url = "http://ocean.baidu.com/realtime/removeApp/";
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
	showLoading(true);
}

function showLoading(show){
	if(show){
		document.getElementById("div_btn").style.display = "none";
		document.getElementById("div_loading").style.display = "block";
	}else{
		document.getElementById("div_btn").style.display = "block";
		document.getElementById("div_loading").style.display = "none";
	}
}

function toStringByZero(str,count) 
{
   while(str.length<count) 
      str="0"+str;
   return str;
}

function getCurrentdate(){
   var s = "";           
   var d = new Date();                       
   s += toStringByZero((d.getYear()+1900)+"",4);                        
   s += toStringByZero((d.getMonth() + 1)+"",2);  
   s += toStringByZero(d.getDate()+"",2);        
   s += toStringByZero(d.getHours()+"",2);
   s += toStringByZero(d.getMinutes()+"",2);
   s += toStringByZero(d.getSeconds()+"",2);   

   return(s);                               
}
