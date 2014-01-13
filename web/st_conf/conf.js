//压力模型相关
 var press_model_content;
 var hending; 
 var jieti;
 var langyong; 
 var zhendang;

function load()
{
	
   showPostData(false);
	//设置压力模型
   press_model_content = document.getElementById("press_model_args");
   hending = document.getElementById("press_model_hending").innerHTML;
   jieti = document.getElementById("press_model_jieti").innerHTML;
   langyong = document.getElementById("press_model_langyong").innerHTML;
   zhendang = document.getElementById("press_model_zhengdang").innerHTML;
   //alert(document.getElementById("press_model") );
   change_press_model(document.getElementById("press_model"));
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

function showPostData(ok){
	if(ok == true){
		//document.getElementById("tb_curlpress").rows[2].style.display="table-row";
		document.getElementById("div_conf_data").style.display="inline";
	}else{
		//document.getElementById("tb_curlpress").rows[2].style.display="none";
		document.getElementById("div_conf_data").style.display="none";
	}
}

function onlynum(text)
{
	text.value=text.value.replace(/[^\d]/g,'');
}


function checkArgs()
{

	var url = document.getElementById("request_url");
	if(url.value == ""){
		alert("url不能为空!");
		url.focus();
		return false;
	}
	
	var press_args = press_model_content.getElementsByTagName("input");
	for(var i=0,len=press_args.length;i<len;i++){
		if(press_args[i].value.replace(/\s/g,'') == ''){
			alert('存在空的压力参数!');
			press_args[i].focus();
			return false;
		}
	}

	var tool_obj = document.getElementById("test_tool");
	var tool = tool_obj.options[tool_obj.selectedIndex].value;

	var server_obj = document.getElementById("run_server");
	var server = server_obj.options[server_obj.selectedIndex].value;

	var result = confirm("您将在服务器"+server+"上部署"+tool+"进行压力测试，你确定你所填数据无误吗？");
	return result;
}


