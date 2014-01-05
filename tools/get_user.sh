
if [ $# -ne 2 ]
then 
	echo "Usage:$0 usertype filename"
	exit 0
fi



get_anonymous()
{
	file=$1
	name=`basename $1`
	anonymous_server="db-testing-bdcm03.db01.baidu.com"
	remote_path="/home/work/jase/jase_sh/user/"
	ssh work@$anonymous_server $remote_path"/genanonymous_new  2000  > "$remote_path$name
	scp work@$anonymous_server":"$remote_path$name $file
}


get_passport()
{
	file=$1
	name=`basename $1`
	passport_server="yx-testing-bdcm08.yx01.baidu.com"
	remote_path="/home/work/passport/"
	ssh work@$passport_server $remote_path"/bdussgenerator -n 2000 -g > "$remote_path$name
	scp work@$passport_server":"$remote_path$name $file
	awk -F ":" '{print $1"@baidu.com/test:"$2":"$3}' $file > $file".tmp"
	mv $file".tmp" $file
}

usertype=$1

filename=$2
if [ $usertype = "passport" ]
then
	get_passport $filename
else
	get_anonymous $filename
fi

#logfile=$filename".log"
#source /home/work/.bash_profile
# ~/jase/bin/jase -i $2 -p $3 --uf $filename -x $dir"jase.xml" -n -1 -S $4  -t $5  -l $logfile >/dev/null 2>&1



