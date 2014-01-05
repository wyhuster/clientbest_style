/**************** 测试部署面板*****************************************/
//这里边比较复杂
///////////////////////定义数据///////////////////////////
var http_tools_data = [['curlpress','curlpress'],
				  ['curlload','curlload']];
var xmpp_tools_data=[ ['xmpp1','xmpp1'],
				  ['xmpp2','xmpp2'] ];
var tools_store = new Ext.data.SimpleStore({
			fields:['name','value'],
			data:http_tools_data
		});

var server_data = [		   ['bdcm02','db-testing-bdcm02.db01.baidu.com'],
				   ['bdcm03','db-testing-bdcm03.db01.baidu.com'],
				   ['bdcm04','db-testing-bdcm04.db01.baidu.com'],
				   ['bdcm05','yx-testing-bdcm05.yx01.baidu.com'],
				   ['bdcm06','yx-testing-bdcm06.yx01.baidu.com'],
				   ['bdcm07','yx-testing-bdcm07.yx01.baidu.com'],
				   ['bdcm08','yx-testing-bdcm08.yx01.baidu.com'],
				   ['ime01','yx-testing-ime01.yx01.baidu.com']
					];
var server_store = new Ext.data.SimpleStore({
			fields:['name','value'],
			data:server_data
		});

var method_field = Ext.create('Ext.form.FieldContainer',{
			fieldLabel:'请求方式',
			defaultType:'radiofield',
			defaults:{
				flex:1
			},
			layout:'hbox',
			items:[{
				boxLabel:'GET',
				name:'request_method',
				inputValue:'GET',
				checked:true
			},{
				boxLabel:'POST',
				name:'request_method',
				inputValue:'POST'
			}]
				
		});
var data_field = Ext.create('Ext.form.field.Text',{
			name:'request_data',
			fieldLabel:'请求数据',
			allowBlank:'false'
	});
var curlload_field = Ext.create('Ext.form.field.Text',{
			name:'request_data',
			fieldLabel:'curlload',
			allowBlank:'false'
	});
var xmpp1_field = Ext.create('Ext.form.field.Text',{
			name:'request_data',
			fieldLabel:'xmpp1',
			allowBlank:'false'
	});
var xmpp2_field = Ext.create('Ext.form.field.Text',{
			name:'request_data',
			fieldLabel:'xmpp2',
			allowBlank:'false'
	});

var curlpress_args = [method_field,data_field];
var curlload_args = [method_field,curlload_field];
var xmpp1_args = [xmpp1_field];
var xmpp2_args = [xmpp2_field];

///////////////////////定义数据结束//////////////////////////
var bushuPanel = Ext.create('Ext.panel.Panel',{
			region:'center',
			id:'bushuPanel',
			title:'部署配置',
			width:600,
			minWidth:600,
			html: '<iframe scrolling="no" frameborder="0" width="100%" height="100%" src="st_conf/conf.php"></iframe>'
		});
var settingPanel = Ext.create('Ext.form.Panel',{
		url:'st_conf/bushu.php',
		frame:true,
		region:'west',
		id:'settingPanel',
		width:1000,
		minWidth:600,
		title:'部署配置',
		bodyStyle:'paddign:5px 5px 0',
		fieldDefaults:{
			msgTarget:'side',
			labelWidth:100
		},
		defaults:{
			anchor:'-400'
		},

		items:[{
			xtype:'fieldset',
			title:'测试工具',
			defaultType:'combo',
			defaults:{
				anchor:'50%',
				allowBlank:false,
				forceSelection:'true',
				triggerAction:'all',
				model:'local',
				editable:false
			},
			items:[{
				fieldLabel:'类型',
				name:'test_type',
				emptyText:'选择测试类型',
				store:['http','xmpp'],
				value:'http',
				listeners:{
					select:function(combo,record,index){
						 switch(combo.value){
							case 'http':
								tools_store.loadData(http_tools_data,false);
								Ext.getCmp('test_tool').setValue('curlpress');
								break;
						 	case 'xmpp':
								tools_store.loadData(xmpp_tools_data,false);
								Ext.getCmp('test_tool').setValue('xmpp1');
								break;		
						 }
							   
					}
				}
			},{
				fieldLabel:'工具',
				emptyText:'选择测试工具',
				name:'test_tool',
				id:'test_tool',
				store:tools_store,
				valueField:'value',
				displayField:'name',
				value:'curlpress',
				listeners:{
					change:function(combo,record,index){
							   var tool_args = Ext.getCmp('tool_args');
								tool_args.removeAll(false);
						 switch(combo.value){
							case 'curlpress':
								tool_args.setTitle('工具选项(curlpress)');
								tool_args.add(curlpress_args);
								break;
						 	case 'curlload':
								tool_args.setTitle('工具选项(curlload)');
								tool_args.add(curlload_args);
								break;		
							case 'xmpp1':
								tool_args.setTitle('工具选项(xmpp1)');
								tool_args.add(xmpp1_args);
								break;
							case 'xmpp2':
								tool_args.setTitle('工具选项(xmpp2)');
								tool_args.add(xmpp2_args);
								break;
							default:
								tool_args.setTitle('工具选项');
								break;

						 }
							   
					}
				}

			},{
				fieldLabel:'运行服务器',
				name:'run_server',
				emptyText:'选择运行服务器',
				store:server_store,
				valueField:'value',
				displayField:'name'
			}]
		},{
			xtype:'fieldset',
			defaultType:'textfield',
			defaults:{
				anchor:'80%'
			},
			title:'工具选项(curlpress)',
			id:'tool_args',
			items:curlpress_args
		},{
			xtype:'fieldset',
			defaultType:'combo',
			defaults:{
				anchor:'80%'
			},
			title:'被测模块',
			items:[{
				fieldLabel:'服务器',
				editable:false,
				name:'server_name',
				emptyText:'选择所在服务器',
				store:server_store,
				valueField:'value',
				displayField:'name'
			}]
		},{
			xtype:'fieldset',
			checkboxToggle:true,
			collapsed:true,
			checkboxName:'loader_control',
			defaultType:'textfield',
			defaults:{
			},
			title:'负载控制',
			items:[{
				fieldLabel:'cpu使用率(%)',
				name:'cpupercent'
			},{
				fieldLabel:'内存使用量(M)',
				name:'memusage'
			}]
		},{
			xtype:'fieldset',
			defaultType:'textfield',
			defaults:{
			},
			title:'压力模型',
			items:[{
				fieldLabel:'cpu使用率(%)',
				name:'cpupercent'
			},{
				fieldLabel:'内存使用量(M)',
				name:'memusage'
			}]
		}]
	}); 
var confHtml = '<iframe scrolling="auto" frameborder="0" width="100%" height="100%" src="st_conf/conf.php"></iframe>';
var confPanel = Ext.create('Ext.panel.Panel',{
			id:'confpanel',
			title:'测试部署',
			layout:{
				type:'fit',
				padding:5
			},
		//	items:[settingPanel,bushuPanel] 
			html: confHtml
	});

