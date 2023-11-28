# promxox-diskmon

#Standalone Version

I have now added a standalone version for machines not in a cluster

#Proxmox Version

Monitors proxmox cluster lxc disk space and sends an email if any goes over 80%

on the cluster master we dont need apahce2 

apt install PHP
apt remove apache2 

set up posix so you can send email successfully, make sure your user has an email address set to send from.

create a  crontab for every hour

@hourly php /root/sysmonitor.php

or if you want it not to send  you a complete update

@hourly php /root/sysmonitor.php >/dev/null 2>&1

Then if any lxc containers space goes over 80% it will email you every hour.

Like this - in this test we were setting it to anything above 40%.

***DISK SPACE WARNING***
lxc/108 regions90 184.65gb 452.21gb 40.83% 


As I only in fact use containers in the cluster (apart from 1 server) this is really what I needed.

**_Note this will only work on a proxmox cluster - install on the cluster master_**
