<?php

error_reporting(E_ALL);
class CMyTime
{
	var $strTime;
	var $nTime;	
};

class CNodeList
{
	public $m_nodelist;
	
	function init()
	{
		$this->m_nodelist = array();
		$this->m_nodelist['0'] = 'aa';
		$this->m_nodelist['1'] = 'sp';
		$this->m_nodelist['2'] = 'up';
		$this->m_nodelist['3'] = 'cp';
		$this->m_nodelist['4'] = 'np';
  }
};

class CIpList
{
	public $m_iplist;
	
	function init()
	{
			$this->m_iplist = array();
			$this->m_iplist['cp1'] = '211.151.186.125:8000';
			$this->m_iplist['cp2'] = '211.151.186.126:8000';
			$this->m_iplist['up1'] = '211.151.186.125:8003';
			$this->m_iplist['up2'] = '211.151.186.126:8003';
			$this->m_iplist['np1'] = '211.151.186.128:8002';
			$this->m_iplist['np2'] = '211.151.186.129:8002';
			$this->m_iplist['sp1'] = '211.151.186.125:8001';
			$this->m_iplist['sp2'] = '211.151.186.126:8001';
			$this->m_iplist['sp3'] = '211.151.186.128:8001';
			$this->m_iplist['sp4'] = '211.151.186.129:8001';
  }
};
function GetTitle($type, &$title)
{
	if( $type<0 || $type>10 )
	{
		return -1;	
	}
	
	switch( $type )
	{
		case 0:
		  $title = "退出客户端总个数 - 不排重";
		  break;
		case 1:
		  $title = "创建任务客户端总个数 - 不排重";
		  break;
		case 2:
		  $title = "任务完成客户端总个数 - 不排重";
		  break;
		case 3:
		  $title = "任务失败客户端总个数 - 不排重";
		  break;
		case 4:
		  $title = "任务创建总次数";
		  break;
		case 5:
		  $title = "任务完成总次数";
		  break;	
		case 6:
		  $title = "任务失败总次数";
		  break;	  		  		  		  
		case 7:
		  $title = "下载平均速度";
			break;	
		case 8:
		  $title = "p2s 贡献流量";
		  break;
		case 9:
			$title = "p2p 贡献流量";
			break;	
		case 10:
		  $title = "平均nat穿透率";
			break;			
	}
	
	
	return 0;
}


//gbk转utf8
function g2u($str){
	return iconv("GBK","UTF-8//ignore",$str);
}

class CMyMicro
{
	public $m_microArr;
	public $m_keyArr;
	
	function init($node)
	{
		$this->m_microArr = array();
		
		if($node<1 || $node>4) $node = 1;
		switch ($node)
		{
				case 1:
				$this->m_keyArr = array("30","33","34","128","129");
				break;
				case 2:
				$this->m_keyArr = array("3","4","5","6","7","8","9","12","13","18","19","22","23","24","25","30","31","32","33","34","61","62","65","66","70","71","96","97","98","128","129");
				break;
				case 3:
				$this->m_keyArr = array("1","2","10","11","128","129");
			  break;
				case 4:
				$this->m_keyArr = array("62","63","64","65","67","68","69","70","71","128","129");
				break;
				default :
				$this->m_keyArr = array();
				break;
	  }
	
		$key = 0x0001; $this->m_microArr[$key] = "C2S_Req_Register";            
		$key = 0x0002; $this->m_microArr[$key] = "S2C_Rsp_Register";                  
		$key = 0x0003; $this->m_microArr[$key] = "C2S_Req_Login";                     
		$key = 0x0004; $this->m_microArr[$key] = "S2C_Rsp_Login";             
		$key = 0x0005; $this->m_microArr[$key] = "C2S_Req_Logout";               
		$key = 0x0006; $this->m_microArr[$key] = "C2S_Req_KeepLive";                  
		$key = 0x0007; $this->m_microArr[$key] = "S2C_Rsp_KeepLive";                
		$key = 0x0008; $this->m_microArr[$key] = "C2S_Req_TransferCallME";            
		$key = 0x0009; $this->m_microArr[$key] = "S2C_Req_CallMe";                    
		$key = 0x000a; $this->m_microArr[$key] = "C2S_Req_DownServerAddr";            
		$key = 0x000b; $this->m_microArr[$key] = "S2C_Rsp_DownServerAddr";           
		$key = 0x000c; $this->m_microArr[$key] = "C2S_Req_UpdateFileToSP";            
		$key = 0x000d; $this->m_microArr[$key] = "S2C_Rsp_UpdateFileToSP";            
		$key = 0x000e; $this->m_microArr[$key] = "C2C_Req_CheckSUMID";                
		$key = 0x000f; $this->m_microArr[$key] = "C2C_Rsp_SetSUMID";                 
		$key = 0x0010; $this->m_microArr[$key] = "C2C_Req_GetFileData";               
		$key = 0x0011; $this->m_microArr[$key] = "C2C_Rsp_GetFileData";               
		$key = 0x0012; $this->m_microArr[$key] = "C2S_Req_CheckSPAlive";              
		$key = 0x0013; $this->m_microArr[$key] = "S2C_Rsp_CheckSPAlive";              
		$key = 0x0014; $this->m_microArr[$key] = "S2S_Req_GetServerInfo";             
		$key = 0x0015; $this->m_microArr[$key] = "S2S_Rsp_GetServerInfo";             
		$key = 0x0016; $this->m_microArr[$key] = "C2S_Req_QueryLastActive";           
		$key = 0x0017; $this->m_microArr[$key] = "S2C_Rsp_QueryLastActive";           
		$key = 0x0018; $this->m_microArr[$key] = "C2S_Req_GetUserHashCount";          
		$key = 0x0019; $this->m_microArr[$key] = "S2C_Rsp_GetUserHashCount";          
		$key = 0x001e; $this->m_microArr[$key] = "S2S_Req_UPNotifySPFileState";       
		$key = 0x001f; $this->m_microArr[$key] = "C2S_Req_SeaFileP2P";                
		$key = 0x0020; $this->m_microArr[$key] = "S2C_Rsp_SeaFileP2P";                
		$key = 0x0021; $this->m_microArr[$key] = "S2S_Req_UPSeaFileFromSP";           
		$key = 0x0022; $this->m_microArr[$key] = "S2S_Rsp_UPSeaFileFromSP";          
		$key = 0x002e; $this->m_microArr[$key] = "C2C_Req_SwapPeers";                 
		$key = 0x002f; $this->m_microArr[$key] = "C2C_Rsp_SwapPeers";                 
		$key = 0x0030; $this->m_microArr[$key] = "C2C_Req_SendVer";                   
		$key = 0x0031; $this->m_microArr[$key] = "C2C_Rsp_SendVer";                   
		$key = 0x0032; $this->m_microArr[$key] = "C2C_Req_SysInfo";                   
		$key = 0x0033; $this->m_microArr[$key] = "C2C_Rsp_SysInfo";                   
		$key = 0x0034; $this->m_microArr[$key] = "C2C_Req_FinishRange";               
		$key = 0x0035; $this->m_microArr[$key] = "C2C_Rsp_FinishRange";               
		$key = 0x0036; $this->m_microArr[$key] = "S2S_Req_UPConfigChange";            
		$key = 0x0037; $this->m_microArr[$key] = "S2S_Req_SPConfigChange";             
		$key = 0x003a; $this->m_microArr[$key] = "S2S_Req_AddHashMonitor";            
		$key = 0x003b; $this->m_microArr[$key] = "S2S_Req_DelHashMonitor";            
		$key = 0x003c; $this->m_microArr[$key] = "S2S_Req_P2PPeerCountNotify";        
		$key = 0x003d; $this->m_microArr[$key] = "C2S_NAT_ClientCheckNat";            
		$key = 0x003e; $this->m_microArr[$key] = "S2S_NAT_ServerToCheck";             
		$key = 0x003f; $this->m_microArr[$key] = "S2C_NAT_CheckToClientFullCone";     
		$key = 0x0040; $this->m_microArr[$key] = "C2S_NAT_CheckToClientFullConeReply";
		$key = 0x0041; $this->m_microArr[$key] = "S2S_NAT_CheckToServerTransCallMe";  
		$key = 0x0042; $this->m_microArr[$key] = "S2C_NAT_CheckCallMe";               
		$key = 0x0043; $this->m_microArr[$key] = "C2S_NAT_CheckCallMeReply";          
		$key = 0x0044; $this->m_microArr[$key] = "S2C_NAT_CheckRestricted";           
		$key = 0x0045; $this->m_microArr[$key] = "C2S_NAT_CheckRestrictedReply";      
		$key = 0x0046; $this->m_microArr[$key] = "S2S_NAT_ResultNotifyServer";        
		$key = 0x0047; $this->m_microArr[$key] = "S2C_NAT_ResultNotifyClient";        
		$key = 0x0048; $this->m_microArr[$key] = "C2S_Req_P2PGetUPDownSvrAddr";       
		$key = 0x0049; $this->m_microArr[$key] = "S2C_Rsp_P2PGetUPDownSvrAddr";       
		$key = 0x004a; $this->m_microArr[$key] = "C2S_Req_P2PGetUPClients";           
		$key = 0x004b; $this->m_microArr[$key] = "S2C_Rsp_P2PGetUPClients";           
		$key = 0x004c; $this->m_microArr[$key] = "C2S_Req_P2PUpdateClientInfo";       
		$key = 0x0060; $this->m_microArr[$key] = "C2S_Req_ServerLookupShareList";     
		$key = 0x0061; $this->m_microArr[$key] = "S2C_Rsp_ServerLookupShareList";     
		$key = 0x0062; $this->m_microArr[$key] = "S2S_Req_ServerTransCallMe";         
		$key = 0x0080; $this->m_microArr[$key] = "C2S_Req_StatReport";                
		$key = 0x0081; $this->m_microArr[$key] = "S2C_Rsp_StatReport";                
		$key = 0x0082; $this->m_microArr[$key] = "S2C_NAT_ClientCheckNatReply";   
	}    
};

?>
