#!/bin/sh
 
version=4.0.2

downloadDir=$HOME/downloads
pwd
if [ ! -d $downloadDir ]; then
  echo "ERROR: Please create the directory $downloadDir"
  exit 1
fi 

cd $downloadDir

#wget http://download.jetbrains.com/webide/PhpStorm-$version.tar.gz

echo "extracting..."

#tar xzf PhpStorm-$version.tar.gz

cd PhpStorm*/bin
#cd bin

file=`pwd`/phpstorm.sh

echo $file

echo "Modifying $file"

sed -i 's/  read IGNORE/#  read IGNORE/g' $file

#sed -i 's/# COMMENT LINE BELOW TO REMOVE PAUSE AFTER OPEN JDK WARNING/# COMMENT LINE BELOW TO REMOVE PAUSE AFTER F**ing OPEN JDK WARNING/g' $file
pwd
