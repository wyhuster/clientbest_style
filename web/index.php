<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv=html content=no-cache>
	<title>客户端后端稳定性测试</title>
	<link rel="stylesheet" type="text/css" href="js/extjs/resources/css/ext-all.css" />
	<script type="text/javascript" src="js/extjs/ext-all-debug.js"></script>
	<script type="text/javascript" src="js/settings.js"></script>
	<script type="text/javascript" src="js/index.js"></script>
	<script type="text/javascript" language="javascript">
Ext.require(['*']);
Ext.onReady(function() {
     
    Ext.create('Ext.container.Viewport',{
		renderTo:Ext.getBody(),
        layout: {
            type: 'border',
            padding: 5
        },
        defaults: {
            split: true
        },
items: [toppanel,menu,main,statuspanel]
    });
});
	</script>
</head>
<body></body>
</html>
