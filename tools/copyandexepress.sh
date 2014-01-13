

usage()
{
	echo "usage: `basename $0` source_file_path server id"
}

if [ $# -ne 3 ];
then
	usage;
	exit;
fi

CURRENT_DIR=`dirname $0`;
SOURCE_FILE_PATH=$1
SERVER=$2
ID=$3
SERVER_PATH="/home/work/clientbest/"
DATA_PATH=${SERVER_PATH}"/data/"
TOOLS_PATH=${SERVER_PATH}"/tools"
LOGS_PATH=${SERVER_PATH}"/logs"
LOG_PATH=$LOGS_PATH"/${ID}_curlpress_log"
ssh "work@"${SERVER} mkdir $SERVER_PATH
ssh "work@"${SERVER} mkdir $DATA_PATH
ssh "work@"${SERVER} mkdir $TOOLS_PATH
ssh "work@"${SERVER} mkdir $LOGS_PATH
ssh "work@"${SERVER} rm -rf $LOG_PATH
ssh "work@"${SERVER} mkdir $LOG_PATH

scp $CURRENT_DIR/press.py "work@"${SERVER}:${TOOLS_PATH}"/press.py"
scp $CURRENT_DIR/curlpress "work@"${SERVER}:${TOOLS_PATH}"/curlpress"
#scp $CURRENT_DIR/get_user.sh "work@"${SERVER}:${TOOLS_PATH}"/get_user.sh"

scp -r ${SOURCE_FILE_PATH} "work@"${SERVER}:${DATA_PATH}"/"
scp ${SOURCE_FILE_PATH}/press.conf "work@"${SERVER}:${TOOLS_PATH}"/press.conf"

#execute
ssh "work@"${SERVER} " cd $TOOLS_PATH && rm python.pid"
ssh "work@"${SERVER} " cd $TOOLS_PATH && python press.py $LOG_PATH" &

sleep 2 #保证python.pid已经存在
scp "work@"${SERVER}:${TOOLS_PATH}"/python.pid" ${SOURCE_FILE_PATH}/python.pid
