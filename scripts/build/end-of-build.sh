#!/bin/bash -e
#
# This script is executed at the end of appliance creation.  Here you can do
# one-time actions to modify your appliance before it is ever used, like
# removing files and directories to make it smaller, creating symlinks,
# generating indexes, etc.
#
# The 'kiwi_type' variable will contain the format of the appliance
# (oem = disk image, vmx = VMware, iso = CD/DVD, xen = Xen).
#

# read in some variables
. /studio/profile

# read in KIWI utility functions
. /.kconfig

### User name config
user=jtester
home=/home/$user
echo "export JDL_USER=$user" >> /etc/profile.local

### Joomla!
echo "export JOOMLA_PLATFORM_PATH=$home/repos/joomla-platform" >> /etc/profile.local
#echo "export JOOMLA_PLATFORM_PATH_11_4=$home/libs/joomla-11.4
#echo "export JOOMLA_PLATFORM_PATH_12_1=$home/libs/joomla-12.1

### The "elkuku" libraries
echo "export KUKU_JLIB_PATH=/home/jtester/repos/elkuku-lilhelpers/joomla-classes" >> /etc/profile.local

#echo "GIT_PS1_SHOWDIRTYSTATE=true

#echo "export PS1="\[\033[1;33m\][\[\033[1;32m\]\u\[\033[1;33m\]|\[\033[1;32m\]\W\[\033[1;33m\]]\[\033[0;32m\]\$(__git_ps1)\[\033[0m\] \$ "

### XAMPP
echo "export PATH=${PATH}:/opt/lampp/bin" >> /etc/profile.local

#xamppBase=`pwd`/lampp
xamppBase=/opt/lampp

httpdconf=$xamppBase/etc/httpd.conf
phpini=$xamppBase/etc/php.ini

sed -i 's,/opt/lampp/htdocs,'$home'/srv/htdocs,g' $httpdconf

sed -i 's,User nobody,User '$user',g' $httpdconf
sed -i 's,Group nogroup,Group users,g' $httpdconf

sed -i 's,ErrorLog logs/error_log,ErrorLog '$home'/srv/logs/error_log,g' $httpdconf

echo 'Include '$home'/srv/*.conf' >> $httpdconf

#sed -i 's,,,g' $httpdconf

sed -i 's,error_log =  "/opt/lampp/logs/php_error_log",error_log =  "'$home'/logs/php_error_log",g' $phpini
sed -i 's,max_execution_time = 30,max_execution_time = 120,g' $phpini
sed -i 's,upload_max_filesize = 2M,upload_max_filesize = 5M,g' $phpini

#sed -i 's,,,g' $phpini

# Disable the SUSE greeter..sry
sed -i 's,true,false,g' $home/.kde4/share/config/SUSEgreeterrc

# Create virtual hosts
echo "127.0.0.1   joomla.local" >> /etc/hosts
echo "127.0.0.1:8080   jenkins.local" >> /etc/hosts
echo "127.0.0.1   linux-dq40" >> /etc/hosts
echo "127.0.0.1    jdevlearn.local" >> /etc/hosts

## Create the /home/server
mkdir -p $home/srv/htdocs

## Just in case...
chown -R $user:users $home

## END
