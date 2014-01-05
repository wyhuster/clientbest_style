var last_log;
var pause;
var area;	
var server;

function showCurlpressLog(pressServer){
	last_log = "";
	pause = 0;
	server=pressServer;
	area = document.getElementById("curlpress_log");
    setInterval(function(){
        if(pause == 0){
            getRemoteLog();
        }
    },1000);
}

function getRemoteLog(){
    xmlHttp=GetXmlHttpObject();
    if (xmlHttp==null)
    {
        alert ("Browser does not support HTTP Request");
        return;
    } 
    var url="get_curlpress_log.php?server="+server;
	//alert(url);
    xmlHttp.onreadystatechange=stateChanged;
    xmlHttp.open("GET",url,true);
    xmlHttp.send(null);
}

function stateChanged() 
{
    if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
    {
        log=xmlHttp.responseText;
        if(log != last_log){
            last_log = log;
            area.value+=log;
            area.scrollTop = area.scrollHeight;
        } 
    } 
}

function GetXmlHttpObject()
{
	var xmlHttp=null;
    try
    {
        // Firefox, Opera 8.0+, Safari
        xmlHttp=new XMLHttpRequest();
    }
    catch (e)
    {
        // Internet Explorer
        try
        {
            xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
        }
        catch (e)
        {
            xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
    }
    return xmlHttp;
}

function setPause(){
    var btn_log = document.getElementById("btn_pause_log");
    if(btn_log.innerHTML == '暂停'){
        pause = 1;
        btn_log.innerHTML = '继续';
    }else{
        pause = 0;
        btn_log.innerHTML = '暂停';
    }
}
