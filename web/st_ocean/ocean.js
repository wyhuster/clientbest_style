	function getTextboxValue(id){
        var text = document.getElementById(id).value;
        var textValue = text.replace(/(^\s*)|(\s*$)/g, "");
        if(textValue == null || textValue == "") {  
            return "";  
        }
        return textValue;
    }

    function getCheckedItems(){
        var array = new Array();
        var c1 = document.getElementById("cpu_idle");
        if(c1.checked){
            array.push(c1.value);
        }
        var c2 = document.getElementById("mem_urate");
        if(c2.checked){
            array.push(c2.value);
        }
        var c3 = document.getElementById("load_avg1");
        if(c3.checked){
            array.push(c3.value);
        }
        var c4 = document.getElementById("io_avg_wait");
        if(c4.checked){
            array.push(c4.value);
        }
        if(array.length == 0){
            return "";
        }else{
            return array.join(",");
        }
    }
    
    function checkArgs(){
        var host = getTextboxValue("hostname");
        var starttime = getTextboxValue("start_date");
        var endtime = getTextboxValue("end_date");
        
        if(host == ""){       
			alert("host不能为空!");
            return;
        }
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
        var items = getCheckedItems();
        if(items == ""){
            alert("请选择监控项!");
            return;
        }
        
        var url = "http://ocean.baidu.com/realtime/graph/?pn=3.1&begin=".concat(starttime).concat("&end=").concat(endtime).concat("&host=").concat(host).concat("&items=").concat(items);
        //window.location.href = url;
        window.open(url);
    }


function showProOcean(){
	var host = getTextboxValue("hostname");
	if(host==null||host==""){
		alert("请填写host!")
		return;
	}
	var frame = document.getElementById("pro_frame");
	frame.src = "pro_ocean.php?host="+host;
	frame.style.display = "block";
	
	//document.getElementById("pro_panel").style.display = "inline";
	//document.getElementById("host_label").innerHTML = "host:".concat(host);
}

