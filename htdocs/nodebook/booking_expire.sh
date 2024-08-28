#!/bin/bash

#
# A script to mail user about booking expiration
#

MY_DIR=`dirname $0`

function print_usage(){
        echo ""
        echo "Usage: $0 <sqlite3_nodebook.db>"
}


if [ $# -eq 1 ]; then
        if [ ! -f $1 ];then
                echo "Database not found: $1"
                print_usage
                exit -1
        fi
else
	print_usage
	exit -1
fi

exit

#sqlite3 database/nodebook.db

# Getting my data
#LIST=`sqlite3 dbname.db "SELECT * FROM data WHERE 1"`;

# For each row
#for ROW in $LIST; do

    # Parsing data (sqlite3 returns a pipe separated string)
#    Id=`echo $ROW | awk '{split($0,a,"|"); print a[1]}'`
#    Name=`echo $ROW | awk '{split($0,a,"|"); print a[2]}'`
#    Value=`echo $ROW | awk '{split($0,a,"|"); print a[3]}'`

    # Printing my data
#    echo -e "\e[4m$Id\e[m) "$Name" -> "$Value;

#done

