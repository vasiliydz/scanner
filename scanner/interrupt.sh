#!/bin/bash
path=/home/user/scanner
cd $path
st=`cat status`
if [ "$st" == "ready 0" ]
then
	exit
fi
pid=`cat mypid`
killall -9 nmap
kill -KILL $pid
echo "interrupted 0" > status
cat ips | while read ip
do
	rm -f ip_info/$ip/raw ip_info/$ip/ports ip_info/$ip/diff_info
done
