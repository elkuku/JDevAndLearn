#!/bin/bash
#
# Dropbox installer
#
# * Download dropbox
# * "Install" it
# * Create an autostart link
#
# @ 2012 by elkuku

# Install to /home/<user>
cd $HOME

# Check architecture
if [ `uname -m` = "x86_64" ]
then
    # 64 bit
    arch="x86_64"
else
    # 32 bit
    arch="x86"
fi

# Download and unpack
wget -O - "https://www.dropbox.com/download?plat=lnx.$arch" --no-check-certificate | tar xzf -

# Create an auto start link
ln -s $HOME/.dropbox-dist/dropboxd $HOME/.kde4/Autostart/dropboxd

# Start the daemon
echo; echo 'Starting the daemon...'
.dropbox-dist/dropboxd

echo "Finished =;)"
