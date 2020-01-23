#!/bin/bash
trap exit SIGTERM
trap exit SIGHUP
path=/home/user/scanner
ip=$1
cd $path
mkdir -p ip_info/$ip
cd ip_info/$ip
if [ $2 == ign ]
then
nmap --open -n -PN -p 1-65535 $ip > raw
else
nmap --open -n -p 1-65535 $ip > raw
fi
python $path/raw_to_ports.py raw ports
rm raw
if [ -f ports_old ]
then
	diff ports ports_old > diff_info
	if [ $? == 0 ]
	then
		rm diff_info ports
	else
		echo $ip >> $path/warns
	fi
fi
