#!/bin/sh

f=`echo $1 | cut -d @ -f 1 | sed 's/xdebug:\/\///'`
l=`echo $1 | cut -d @ -f 2`

# Eclipse
# path/to/eclipse $f
#/home/jtester/eclipse/indigogit2/eclipse $f

# Netbeans
# path/to/netbeans $f:$l
# /home/jtester/netbeans-7.0/bin/netbeans $f:$l

# Kate
# kate $f -l $l

# Kwrite
# kwrite $f --line $l

# PHPStorm
#/home/jtester/bin/phpstorm/bin/phpstorm.sh $f
~/scripts/start/phpstorm-openwithfile.py --line $l $f 
