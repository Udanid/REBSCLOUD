#!/bin/bash
echo "Accounts pro DB backup started"
mysqldump -u root --password='DMCaCCPawDMCaCCPaw' -A > /home/dmc/Desktop/Accounts_Pro_DB_Backups/Accounts_DB_Backup_`date +%Y-%b-%d_%H-%M`.sql
chmod 777 /home/dmc/Desktop/Accounts_Pro_DB_Backups/Accounts_DB_Backup_`date +%Y-%b-%d_%H-%M`.sql
echo "Backup completed."
