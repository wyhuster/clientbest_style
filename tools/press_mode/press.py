import ConfigParser
import os,time
import sys
import shlex,subprocess
import signal
import threading
import random
from threading import Thread


press_cf=ConfigParser.ConfigParser()
press_cf.read("press.conf")
press_mode=press_cf.get("mode","mode")
tool_path=press_cf.get("mode","tool_path")
case_path=press_cf.get("mode","case_path")
tool=press_cf.get("mode","tool")
running_tools = []
tools_mutex = threading.Lock()
is_running = True
#print "press_mode",press_mode
#curlpress log path
log_path = sys.argv[1] + "/";
				
class Tool:
		def	__init__(self,tool_path,tool_name,case_path):
			self.tool_name = tool_name
			self.tool_path = tool_path
			self.case_path = case_path
		def getHighestQps(self):
			return self._highest_qps
		def setQps(self,qps):
			self.mode_qps = str(qps)
		def _pre_execute(self):
			pass
		def execute(self):
			print self._cmd + "\n"
			return subprocess.Popen(shlex.split(self._cmd),shell=False)
		def run(self):
			self._createCase()
			self.getParams()
			#self._pre_execute()
			return self.execute()
			
		
class CurlpressTool(Tool):
	def __init__(self,toolpath,case_path):
		Tool.__init__(self,toolpath,"curlpress",case_path)
		self.__case=""
		self._highest_qps = 2000
	
	def	_createCase(self):
		self.__case = self.case_path + "case_" + self.mode_qps + "_" + str(random.randint(100,999))
		self.fp=open(self.__case,"w");
		self.fp.write("threadnum="+ self.mode_qps +"\n")
		self.__type=press_cf.get("curlpress","type")
		self.fp.write("type="+self.__type+"\n")
		self.__url=press_cf.get("curlpress","url")
		self.fp.write("url="+self.__url+"\n")
		try:
			self.__data=press_cf.get("curlpress","data")
		except:
			print "No data!!"
		else:	
			self.fp.write("data="+self.__data+"\n")

		try:
			self.__cookie=press_cf.get("curlpress","cookie")
		except:
			print "No cookie!!"
		else:
			self.fp.write("cookie="+self.__cookie+"\n")
		self.fp.write("###"+"\n")
		self.fp.close()
		
	def	getParams(self):
		self._cmd = self.tool_path+"curlpress --speed=MIN --save=0 --data=" + self.__case 
	### save the pre logs
	#def _pre_execute(self):
	#	if os.path.exists("./curlpress.log"):
	#	   self.file_prefix = time.strftime('%Y%m%d_%H%M%S',time.localtime(time.time()));
	#	   os.rename("./curlpress.log",self.case_path+ self.file_prefix +"_qps"+self.mode_qps+"_curlpress.log")
		
		
			
class JaseTool(Tool):
	def __init__(self,toolpath,case_path):
		Tool.__init__(self,toolpath,"curlpress",case_path)
		self.__case=""
		self._highest_qps = 1500
		
	def	_createCase(self):
		self.__server=press_cf.get("jase","server")
		self.__port=press_cf.get("jase","port")
		self.__usertype=press_cf.get("jase","user_type")
		self.__file = self.case_path+ time.strftime('%Y%m%d_%H%M%S',time.localtime(time.time())) + "_" + str(random.randint(100,999))
		self.__userfile = self.__file + "_username_" + self.__usertype + ".log"
		self.__logfile = self.__file + ".log" 
		self.__getcmd = "sh " + self.tool_path+"/get_user.sh" + " " + self.__usertype + " " + self.__userfile 
		subprocess.call(self.__getcmd,shell=True)
		return True;
	
	def	getParams(self):
		self._cmd = "jase -i " + self.__server + " -p " + self.__port + " --uf " + self.__userfile + " -x " + self.case_path + " -n 1 -S 1000000 -t " + self.mode_qps + " -l " + self.__logfile #+ " >/dev/null 2>&1"


class ExitTimer(Thread):
	def __init__(self,runTime):
		self.__time = runTime
		Thread.__init__(self, None, "ExitTimer", None)

	def run(self):
		time.sleep(self.__time);
		is_running = False
		print "time is over,exit!!"
		end_press()
		save_curlpress_log("test")
		os._exit(1)
##only reserve the lastest log files in one hour
class DelLogTimer(Thread):
	def __init__(self):
		Thread.__init__(self, None, "DelLogTimer", None)
	def run(self):
		while True:
			time.sleep(600)
			os.system("find " + case_path +" -mmin +60 -name \"*.log\" |xargs rm")
			os.system("find " + case_path +" -mmin +60 -name \"case_*\" |xargs rm")

def begin_press(tool_name,tool_path,case_path,qps):
	if is_running == False:
		sleep(10)
		return None
	
	if tool_name == "curlpress":
		tool = CurlpressTool(tool_path,case_path)
	elif tool_name == "jase":
		tool = JaseTool(tool_path,case_path)
	else:
		print "The tool " + tool_name + "can't be suported!!\n"
		os._exit(1);
		return None
	now_qps = int(qps)
	highest_qps = tool.getHighestQps()
	tools_mutex.acquire()
	while highest_qps < now_qps:
		tool.setQps(highest_qps)
		run_tool = tool.run()
		running_tools.append(run_tool)
		now_qps -= highest_qps
	if qps > 0:
		tool.setQps(now_qps)
		run_tool = tool.run()
		running_tools.append(run_tool)
	tools_mutex.release()

def end_press():
	global running_tools
	tools_mutex.acquire()
	for run_tool in running_tools:
		print "kill " + tool 
		run_tool.terminate()	
	running_tools = []
	tools_mutex.release()

### save curlpress logs
def save_curlpress_log(qps):
	if os.path.exists("./curlpress.log"):
		file_prefix = time.strftime('%Y%m%d_%H%M%S',time.localtime(time.time()));
		#os.system("cp ./curlpress.log "+ case_path + file_prefix +"_qps"+ str(qps) +"_curlpress.log")
		if str(qps).isdigit():
			os.system("cp ./curlpress.log "+ log_path + file_prefix +"_qps"+ str(qps) +".log")
		else:
			os.system("cp ./curlpress.log "+ log_path + file_prefix +".log")
			


def hengding(mode):
	mode_qps = press_cf.get(mode,"qps")
	mode_time = press_cf.get(mode,"time")
	os.system("rm ./curlpress.log")
	begin_press(tool,tool_path,case_path, mode_qps)
	time.sleep(float(mode_time) * 60)
	end_press()
	save_curlpress_log(mode_qps)
	os._exit(0)
    

def jieti(mode):
    mode_qps_start = press_cf.get(mode,"qps_start")
    mode_qps_end = press_cf.get(mode,"qps_end")
    mode_qps_interval = press_cf.get(mode,"qps_interval")
    mode_time_interval = press_cf.get(mode,"time_interval")
    qps_now = mode_qps_start

    while True:
		print qps_now
		print mode_qps_end
		if int(qps_now) <= int(mode_qps_end):
			os.system("rm ./curlpress.log")
			begin_press(tool,tool_path,case_path,qps_now)
			time.sleep(int(mode_time_interval) * 60)
			end_press()
			save_curlpress_log(qps_now)
			qps_now = int(qps_now) + int(mode_qps_interval)
			
			#sleep 1 minute between each qps
			if int(qps_now) <= int(mode_qps_end):
				print "sleep 1 minute..."
				time.sleep(60)
			else:
				pass
		
		else:
			end_press()
			os._exit(0)
			#time.sleep(int(mode_time_interval) * 60)
			
def langyong(mode):
    mode_qps_low = press_cf.get(mode,"low_qps")
    mode_qps_high = press_cf.get(mode,"high_qps")
    mode_time_interval = press_cf.get(mode,"time_interval")
    mode_time = int(press_cf.get(mode,"time")) * 60
    ExitTimer(int(mode_time)).start();

    os.system("rm ./curlpress.log")
    while True:
		begin_press(tool,tool_path,case_path, mode_qps_low)
		time.sleep(int(mode_time_interval) * 60)
		end_press()

		begin_press(tool,tool_path,case_path, mode_qps_high)
		time.sleep(int(mode_time_interval) * 60)
		end_press()


def zhendang(mode):
    mode_qps_low = press_cf.get(mode,"low_qps")
    mode_qps_high = press_cf.get(mode,"high_qps")
    mode_time = int(press_cf.get(mode,"time")) * 60
    ExitTimer(int(mode_time)).start()

    os.system("rm ./curlpress.log")
    while True:
		begin_press(tool,tool_path,case_path, mode_qps_low)
		time.sleep(20)
		end_press()

		begin_press(tool,tool_path,case_path, mode_qps_high)
		time.sleep(20)
		end_press()



#sig handler when exit
#end press  tool
#

def handler(signum,frame):
	end_press()
	print "exit.\n"
	os._exit(0)
	
signal.signal(signal.SIGINT, handler)
signal.signal(signal.SIGTERM, handler)

fp=open("python.pid","w");
fp.write(str(os.getpid()));
fp.close();
#DelLogTimer().start()
if press_mode=="hengding":
    hengding("hengding")
elif press_mode=="jieti":
    jieti("jieti")
elif press_mode=="langyong":
    langyong("langyong")
elif press_mode=="zhendang":
    zhendang("zhendang")
else:
    print "wrong mode!\n"



