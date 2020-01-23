#!/bin/bash
trap 'echo "interrupted 0" > status; exit' SIGTERM
path=/home/user/scanner
cd $path
cat /dev/null > warns
num=`cat ips | wc -l`
n=0
echo $$ > mypid

cat ips | while read ip
do
	if [ -f ip_info/$ip/ports ]
	then	
		rm -f ip_info/$ip/ports_old
		mv ip_info/$ip/ports ip_info/$ip/ports_old
	fi
	rm -f ip_info/$ip/diff_info
done

echo "scanning $n $num" > status
cat ips | while read ip
do
	bash scan.sh $ip $1
	n=$(($n+1))
	echo "scanning $n $num" > status
done
echo "done 0" > status
