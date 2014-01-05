
uage()
{
	echo "usage: `basename $0` source_file server"
}

if [ $# -ne 2 ];
then
	usage;
	echo "ERROR,参数不正确!"
	exit;
fi


CURRENT_DIR=`dirname $0`;
LOADER_CONFIG_FILE=$1
SERVER=$2
SERVER_PATH="/home/work/clientbest/tools"

ssh "work@"${SERVER} mkdir $SERVER_PATH

ssh "work@"${SERVER} killall loader
scp ${CURRENT_DIR}/loader work@${SERVER}:${SERVER_PATH}/loader
if [ $? -ne 0 ]
then
	echo "无法在${SERVER}上部署loader"
	exit
fi

scp $LOADER_CONFIG_FILE "work@"${SERVER}:${SERVER_PATH}"/loader.cfg"

if [ $? -ne 0 ]
then
	echo "无法在${SERVER}上部署loader.cfg"
	exit
fi


##execute
ssh "work@"${SERVER} "${SERVER_PATH}/loader -cm -f ${SERVER_PATH}/loader.cfg > ${SERVER_PATH}/loader.log" &
if [ $? -eq 0 ]
then
	echo "OK"
else
	echo "ERROR"
fi

