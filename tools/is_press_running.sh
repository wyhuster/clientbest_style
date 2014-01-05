

usage()
{
	echo "usage: `basename $0` pid server"
}

if [ $# -ne 2 ];
then
	usage
	exit
fi

#execute
ssh work@$2 "ps -ef |grep 'python press.py' | grep $1 |grep -v grep|wc -l" 
