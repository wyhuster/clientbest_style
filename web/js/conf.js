//压力模型相关
 var press_model_content;
 var hending; 
 var jieti;
 var langyong; 
 var zhendang;

 //工具相关
 var tool_content;
 var tool_curlpress;
 var tool_curlload;
 var tool_jase;
 var tool_xmpp2;
 

function load()
{
	 
	//设置压力模型
   press_model_content = document.getElementById("press_model_args");
   hending = document.getElementById("press_model_hending").innerHTML;
   jieti = document.getElementById("press_model_jieti").innerHTML;
   langyong = document.getElementById("press_model_langyong").innerHTML;
   zhendang = document.getElementById("press_model_zhengdang").innerHTML;
   //alert(document.getElementById("press_model") );
   change_press_model(document.getElementById("press_model"));


   //设置工具
   tool_content = document.getElementById("tool_args");
   tool_curlpress = document.getElementById("tool_curlpress").innerHTML;
   tool_curlload  = document.getElementById("tool_curlload").innerHTML;
   tool_jase  = document.getElementById("tool_jase").innerHTML;
   tool_xmpp2  = document.getElementById("tool_xmpp2").innerHTML;
   
   change_type(document.getElementById("test_type"));

}


function change_type(obj)
{
   var tools =[
	   ["curlpress"],  /* http */ 
	   ["jase","xmpp2"]          /* xmpp */
	];
    
    var tool;
   
	var type = obj.options[obj.selectedIndex].value;
	switch(type){
	case "http":
		tool = tools[0];
		break;
	case "xmpp":
		tool = tools[1];
		break;
	default:
		tool = [];
		alert("不支持的测试类型！！！");
	}
	
	var test_tool = document.getElementById("test_tool");
	test_tool.length = 0;
	for(i = 0; i < tool.length; i ++){
		test_tool[i] = new Option(tool[i],tool[i]);
	}

	change_tool(test_tool);
	
}

function change_tool(obj)
{

	var tool = obj.options[obj.selectedIndex].value;
	switch(tool){
	case "curlpress":
		tool_content.innerHTML = tool_curlpress;
		break;
	case "curlload":
		tool_content.innerHTML = tool_curlload;
		break;
	case "jase":
		tool_content.innerHTML = tool_jase;
		break;
	case "xmpp2":
		tool_content.innerHTML = tool_xmpp2;
		break;
	default:
		alert("不支持的工具!!!");
	
	
	}
}

function change_press_model(obj)
{
	var model = obj.options[obj.selectedIndex].value;
	
	switch(model){
	case "hengding":
		press_model_content.innerHTML = hending;
		break;
	case "zhendang":
		press_model_content.innerHTML = zhendang;
		break;
	case "jieti":
		press_model_content.innerHTML = jieti;
		break;
	case "langyong":
		press_model_content.innerHTML = langyong;
		break;
	default:
		alert("压力模型"+model+"选择不正确！！！");

	}
	
}

function onlynum(text)
{
	text.value=text.value.replace(/[^\d]/g,'');
}

function showLoaderArgs( show)
{
	var style = document.getElementById("Loader_args").style;
	if(show)
		style.display = "block";
	else
		style.display = "none";
}

function checkTool(){
	var obj = document.getElementById("test_tool");
	var tool = obj.options[obj.selectedIndex].value;
	switch(tool){
	case "curlpress":
		var text = document.getElementById("request_data")
	//	alert(text.value);
	//	data = text.value;
	//		if(data == "")return false;
		break;
	case "curlload":
		break;
	case "jase":
		break;
	case "xmpp2":
		break;
	default:
		alert("不支持的工具!!!");
		return false;
	}
	return true;
}

function checkArgs()
{

	if(!checkTool()) 
		return false;

	var tool_obj = document.getElementById("test_tool");
	var tool = tool_obj.options[tool_obj.selectedIndex].value;

	var server_obj = document.getElementById("run_server");
	var server = server_obj.options[server_obj.selectedIndex].value;

	var result = confirm("您将在服务器"+server+"上部署"+tool+"进行压力测试，你确定你所填数据无误吗？");
	return result;
}


