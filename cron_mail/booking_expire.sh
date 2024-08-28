#!/bin/bash

#
# A script to mail user about booking expiration
#

MY_DIR=`dirname $0`

function print_usage(){
        echo ""
        echo "Usage: $0 <sqlite3_nodebook.db> [-VERBOSE]"
}


if [ $# -eq 1 -o $# -eq 2 ]; then
        if [ ! -f $1 ];then
                echo "Database not found: $1"
                print_usage
                exit -1
        fi
else
	print_usage
	exit -1
fi


if [ $# -eq 2 -a "$2" = "-VERBOSE" ]; then
	VERBOSE="VERBOSE"
fi


DATABASE=$1
TODAY=`date +"%Y-%m-%d"`

function sendNotificationMail(){
	local EMAIL=$1
	local END_DATE=$2
	local ALIAS=$3
	
	if [ "$EMAIL" = "" ]; then
		echo "No email address"
		return -1
	fi
	
	if [ "$END_DATE" = "" ]; then
		echo "No end date"
		return -1
	fi
	
	if [ "$ALIAS" = "" ]; then
		echo "No alias"
		return -1
	fi
		
	
	local OUT_FILE="$(mktemp)"
	local SUBJECT="You Test System Reservation will expire ${END_DATE} for system: ${ALIAS}"	
	echo "Please renew your reservation for system: ${ALIAS} before: ${END_DATE}" > $OUT_FILE		
	echo "Renewal can be done here: http://10.64.88.97/nodebook"  >> $OUT_FILE
	echo "For issues regarding this email, please contact: PDLMI5TEAM@ex1.eemea.ericsson.se"  >> $OUT_FILE
	
	# send an email using /bin/mail
	/bin/mail -s "$SUBJECT" "$EMAIL" < $OUT_FILE
	
	if [ "$VERBOSE" = "VERBOSE" ]; then
		echo "Sending notification to: $EMAIL about: $ALIAS on: $END_DATE"
		echo "Message:"
		cat $OUT_FILE		
	fi

	rm -f $OUT_FILE
		
	return 0
}

function updateSystemInDB(){
	local ID=$1
	if [ "$ID" = "" ]; then
		echo "No userID"
		return -1
	fi
	
	UPDATE_EMAIL=`sqlite3 $DATABASE "update system set email_sent='true' where id = ${ID}"`;
	
	if [ "$VERBOSE" = "VERBOSE" ]; then
		echo "Updating DB for user: $ID Result: $UPDATE_EMAIL"
	fi
		
	return 0
}


# Get data
sqlite3 $DATABASE "select s.id, s.userid, s.alias, s.end_date, s.book_date, u.email \
from system as s, user as u \
where s.end_date>=date('now','-0 day') and s.end_date<date('now','+5 day') \
and s.end_date!='' and s.userid!='' and s.userid=u.id and s.email_sent='false' \
and u.email!=''" | while read ROW
do
	# For each row
	#echo $ROW
	
	SYSTEM_ID=`echo $ROW | awk '{split($0,a,"|"); print a[1]}'`
	SYSTEM_ALIAS=`echo $ROW | awk '{split($0,a,"|"); print a[3]}'`
	END_DATE=`echo $ROW | awk '{split($0,a,"|"); print a[4]}'`
	BOOK_DATE=`echo $ROW | awk '{split($0,a,"|"); print a[5]}'`
	MAIL_ADDR=`echo $ROW | awk '{split($0,a,"|"); print a[6]}'`
	
	#echo "end_date=$END_DATE"
	#echo "book_date=$BOOK_DATE"
	
	SEC_QUERY=`sqlite3 $DATABASE "SELECT strftime('%s','${END_DATE}') - strftime('%s','${BOOK_DATE}') as diff"`;
	
	if [ "$SEC_QUERY" = "" -a "$VERBOSE" = "VERBOSE" ]; then
		echo "Empty SEC_QUERY for ID=$SYSTEM_ID SYSTEM_ALIAS=$SYSTEM_ALIAS END_DATE=$END_DATE BOOK_DATE=$BOOK_DATE"
		echo "ROW=$ROW"
		continue
	fi
		
	let DAYS=($SEC_QUERY/86400)+1
		
	TODAY_SEC_QUERY=`sqlite3 $DATABASE "SELECT strftime('%s','${TODAY}') - strftime('%s','${BOOK_DATE}') as diff"`;
		
	let DAYS_PASSED=($TODAY_SEC_QUERY/86400)+1
		
	let DAYS_LEFT=$DAYS-$DAYS_PASSED
		
	let HAFTIME=DAYS/2
		
	# No info for only one day booking
	if [ $DAYS -le 1 ]; then
		#echo "ignore only one day"
		continue
	fi
	
	# No info on first day for 2 day booking
	if [ $DAYS -eq 2 -a $DAYS_LEFT -eq 1 ]; then
		#echo "ignore first day"
		continue
	fi
		 	 	
	if [ $DAYS_LEFT -le 3 -a $HAFTIME -ge $DAYS_LEFT ]; then				
		sendNotificationMail "$MAIL_ADDR" "$END_DATE" "$SYSTEM_ALIAS"
		MAIL_RESULT=$?	
		if [ "$MAIL_RESULT" = "0" ]; then
			updateSystemInDB $SYSTEM_ID
		fi
	fi	 	 		
done
