/*
 *构造主界面元素
 */



/*******************top panel**********************************/
var toppanel = Ext.create('Ext.panel.Panel',{
			region:'north',
			height:80,
            html: '<iframe scrolling="no" frameborder="0" width="100%" height="100%" src="top.php"></iframe>'       
		});

/*******************menu panel  **********************************/
function showMainPanel(name){
	var main_panel = Ext.getCmp('mainpanel');
	var mainlayout = main_panel.getLayout();
	switch(name){
		case 'conf':
			mainlayout.setActiveItem('confpanel');	
			confPanel.update(confHtml);
			break;
		case 'monitor':
			mainlayout.setActiveItem('monitorpanel');	
			monitorPanel.update(monitorHtml);
			break;
		case 'data':
			mainlayout.setActiveItem('datapanel');	
			dataPanel.update(dataHtml);
			break;
		case 'history':
			mainlayout.setActiveItem('historypanel');	
			historyPanel.update(historyHtml);
			break;
	}
}


var menu = Ext.create('Ext.panel.Panel',{
			region:'west',
			spilt:true,
			title:'稳定性测试',
			width:200,
			minheight:'100%',
			minHeight:'100%',
			layout:{
				type:'anchor',
				padding:20,
			},
			items:[
			{
				xtype:'button',
				text:'测试部署',
				anchor:'80%',
				handler:function(){showMainPanel('conf');}
			},
			{
				xtype:'button',
				text:'测试监控',
				anchor:'80%',
				handler:function(){showMainPanel('monitor');}
			},
			{
				xtype:'button',
				text:'数据回放',
				anchor:'80%',
				handler:function(){showMainPanel('data');}
			},
			{
				xtype:'button',
				text:'使用历史',
				anchor:'80%',
				handler:function(){showMainPanel('history');}
			},
			{
				xtype:'button',
                text:'Ocean监控',
                anchor:'80%',
                handler:function(){showMainPanel('history');}
			}
			]
});

/*******************status panel  **************************************/
var statuspanel = Ext.create('Ext.panel.Panel',{
		region: 'south',
		height: 20,
		html:'&nbsp;'
	});



/*******************intro panel **************************************/
var introPanel = Ext.create('Ext.panel.Panel',{
			title:'简介',
            html: '<iframe scrolling="auto" frameborder="0" width="100%" height="100%" src="intro.php"></iframe>'       
	});


/*******************monitor panel ***********************************/
var monitorHtml =  '<iframe scrolling="auto" id="monitorFrame"scrolling="no" frameborder="0" width="100%" height="100%" src="st_monitor/monitor.php"></iframe>';      

var monitorPanel = Ext.create('Ext.panel.Panel',{
			id:'monitorpanel',
			title:'测试监控',
		    html:monitorHtml	
});





/*******************data panel ***********************************/
var dataHtml = '<iframe scrolling="auto" frameborder="0" width="100%" height="100%" src="st_data/data_show.php"></iframe>';      
var dataPanel = Ext.create('Ext.panel.Panel',{
			id:'datapanel',
			title:'数据回放',
            html: dataHtml
	});

/*******************history panel ***********************************/
var historyHtml = '<iframe scrolling="auto" frameborder="0" width="100%" height="100%" src="st_history/history.php"></iframe>';
var historyPanel = Ext.create('Ext.panel.Panel',{
			id:'historypanel',
			title:'历史记录',
            html: historyHtml 
	});


/*******************main panel **************************************/

var main = Ext.create('Ext.panel.Panel',{
		id:'mainpanel',
		region: 'center',
		border: false,
		layout: 'card',
		activeItem:1,
		minWidth:600,
		items:[introPanel,confPanel,monitorPanel,dataPanel,historyPanel]
		
	});

