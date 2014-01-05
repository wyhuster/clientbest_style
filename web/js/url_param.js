$(function(){

	var tool_args_wrapper = "#tool_args";	
		
    $(tool_args_wrapper + " #add_param_btn").live('click', function(){
		var param_element = "<input type='text'/>";
        $(tool_args_wrapper + " #params_container").append(param_element);        
    });
    
    $(tool_args_wrapper + " #clear_url_btn").live('click', function(){
       $(tool_args_wrapper + " #params_container").empty();
       $(tool_args_wrapper + " #generated_url_container").empty(); 
    });
    
    $(tool_args_wrapper + " #generate_url_btn").live('click', function(){
		var each_param,
		    params = [],
			urls,
			url = $(tool_args_wrapper + " #request_url").val();
		$(tool_args_wrapper + " #params_container input").each(function(index, param_ele){
			each_param = $(param_ele).val();
			if(each_param === "") return;
			params.push(each_param);
		});
		urls = generate_urls(url, params, append_urls);
    });

    function append_urls(urls_str) {
		var url_group_container = tool_args_wrapper + " #generated_url_container",
			full_url_ele,
			urls = JSON.parse(urls_str);

		for(var index in urls) {
			full_url_ele = "<input type='radio' name='full_url' value='" + urls[index] + "'>" + urls[index] + "<br>";
			$(url_group_container).append(full_url_ele);     
		}
	}

	function generate_urls(url, params, callback) {
		var request_data = {
			url:url,
			params:params,
			dataType:'json'
		};
		$.get("/clientbest/web/st_url/urls.php", request_data, callback);
	}
});
