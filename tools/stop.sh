

usage()
{
	echo "usage: `basename $0` toolname pid server"
}

if [ $# -ne 3 ];
then
	usage
	exit
fi

#execute
ssh work@$3 "kill $2" 

###ssh work@$3 "killall $1" 
