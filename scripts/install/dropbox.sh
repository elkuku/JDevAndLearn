#!/bin/bash
#
# Dropbox installer
#
# * Download dropbox
# * "Install" it
# * Create an autostart link
#

cd ~

if [ `uname -m` = "x86_64" ]
then
    # 64 bit
    arch="x86_64"
else
    # 32 bit
    arch="x86"
echo 32
fi

# Download and unpack
wget -O - "https://www.dropbox.com/download?plat=lnx.$arch" --no-check-certificate | tar xzf -

# Create an auto start link
ln -s $HOME/.dropbox-dist/dropboxd $HOME/.kde4/Autostart/dropboxd

# Start the daemon
.dropbox-dist/dropboxd &

echo "Finished =;)"
