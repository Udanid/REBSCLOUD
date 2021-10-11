#!/bin/bash

datetime=$(date +'%Y-%m-%dT%H:%M:%S')
path="/var/www/html/rebserp/application"
tar -czvf /var/www/html/rebserp/application/homelands_$datetime.tar.gz $path/controllers/ $path/helpers/ $path/libraries/ $path/models/ $path/third_party/ $path/views/

HOST='ftp.beit.lk'
USER="beitlk"
PASSWD="ud@93#beitSrilanka"
REMOTEPATH='/gcloud_backups/www_backups'
FILE="homelands_$datetime.tar.gz"

cd /var/www/html/rebserp/application/
ftp -n $HOST <<END_SCRIPT
quote USER $USER
quote PASS $PASSWD
cd $REMOTEPATH
put $FILE 
quit

END_SCRIPT

rm -f $FILE
exit 0
